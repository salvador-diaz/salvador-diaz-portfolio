import { useState, useEffect, useRef } from 'react'
import * as THREE from 'three'; // npm install three
import { TTFLoader } from 'three/examples/jsm/loaders/TTFLoader';
import { FontLoader } from 'three/examples/jsm/loaders/FontLoader';
import { TextGeometry } from 'three/examples/jsm/geometries/TextGeometry';

//import {OrbitControls} from 'three/examples/jsm/controls/OrbitControls.js';
//import Stats from 'three/addons/libs/stats.module.js';

export default function IndexCanvas() {
   const refContainer = useRef(null);
    useEffect(() => {

        // Renderer, se encarga del canvas
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(
            document.documentElement.clientWidth,
            window.innerHeight
        );
        // Añadir al HTML
        if (refContainer.current)
            refContainer.current.appendChild(renderer.domElement);

        const scene = new THREE.Scene();
        // Usamos ortográfica para que no se tome en cuenta la distancia de la camara.
        const camera = new THREE.OrthographicCamera(
            document.documentElement.clientWidth / -2, document.documentElement.clientWidth / 2,
            window.innerHeight / 2, window.innerHeight / -2, 
            0.1, // near render limit
            1000 // far render limit
        );
        camera.position.z = 500; // igual hay que setear z

        // permite mover y girar la camara. Sirve mucho como debug
        //const orbit = new OrbitControls(camera, renderer.domElement);
        // Muestra FPS
        //const stats = new Stats();
        //refContainer.current.appendChild(stats.dom);
        const clock = new THREE.Clock();

        // Geometria, material y mesh del plano
        var planeGeometry = new THREE.PlaneGeometry(
            document.documentElement.clientWidth,
            window.innerHeight
        );
        const video = document.getElementById("dockerscript-video");
        const texture = new THREE.VideoTexture(video);
        video.play();
        const pixelShader = {
          uniforms: {
            tDiffuse: {value: texture},                     // La textura de la imagen
            resolution: {value: new THREE.Vector2(document.documentElement.clientWidth, window.innerHeight)}, // Resolución de la pantalla
            pixelSize: {value: 12.5},                        // Tamaño de cada píxel
            radius: {value: 0.02},                          // Radio de pixelación normalizado
            mouse: {value: new THREE.Vector2(0.5, 0.5)},    // Posición del cursor normalizada
            u_time: {value: clock.getElapsedTime()}
          },
          vertexShader: `
            varying vec2 vUv;
            void main() {
              vUv = uv;
              gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
            }
          `,
          fragmentShader: `
            uniform sampler2D tDiffuse;
            uniform vec2 resolution;
            uniform float pixelSize;
            uniform vec2 mouse;
            uniform float radius;
            varying vec2 vUv;
            uniform float u_time;
                        
            // genera número aleatorio
            float random(vec2 st) {
                return fract(sin(dot(st.xy, vec2(12.9898, 78.233))) * 43758.5453123);
            }
            // interpolar suavemente con el radio
            float noise(vec2 st) {
                vec2 i = floor(st);
                vec2 f = fract(st);

                // Suavizado
                vec2 u = f * f * (3.0 - 2.0 * f);

                return mix(mix(random(i + vec2(0.0, 0.0)),
                               random(i + vec2(1.0, 0.0)), u.x),
                           mix(random(i + vec2(0.0, 1.0)),
                               random(i + vec2(1.0, 1.0)), u.x), u.y);
            }

            void main() {

                // Usar aspect para evitar stretching del circulo
                vec2 aspect = vec2(resolution.x / resolution.y, 1.);
                vec2 mouseUV = mouse * aspect;
                vec2 uv = vUv * aspect;

                vec2 dxy = pixelSize / resolution;
                vec2 coord = dxy * floor(vUv / dxy);
              
                // Calcular la distancia desde el cursor
                float dist = distance(uv, mouseUV);

                /// Añadir ruido para distorsionar el borde del círculo
                float noiseFactor = noise(vUv * 15.0 + u_time * 0.3) * 0.12; // (Posición * suavizado_ruido + tiempo * velocidad) * distorsion en borde
                noiseFactor = max(noiseFactor, 0.);
                // Cambiar el radio del borde usando el ruido
                float distortedRadius = max(radius + noiseFactor, radius); // el radio minimo sera el radio original

                // Animación para agrandar/achicar radio. sin(tiempo * velocidad_de_variacion) * amplitud radio
                //float animatedRadius = radius + sin(u_time * 2.) * 0.05; // seno oscila entre 1 y -1
                //float smoothFactor = smoothstep(animatedRadius, animatedRadius - 0.03, dist);

                // Factor de suavizado del borde
                float smoothness = 0.03; 
                float smoothFactor = smoothstep(distortedRadius, distortedRadius - smoothness, dist);

                vec4 pixeledFragment = texture2D(tDiffuse, coord); // Pixelar
                vec4 unalteredFragment = texture2D(tDiffuse, vUv); // No pixelar

                gl_FragColor = mix(unalteredFragment, pixeledFragment, smoothFactor);
            }
          `
        };
        const pixelMaterial = new THREE.ShaderMaterial(pixelShader);
        const pixelPlane = new THREE.Mesh(planeGeometry, pixelMaterial);

        scene.add(pixelPlane);

        let font;
        let mesh1;
        let mesh2;
        function createText(text, size, font) {
            const textGeometry = new TextGeometry(text, {
                depth: 15,
                size: size,
                font: font,
            });

            const textMaterial = new THREE.MeshStandardMaterial();
            return new THREE.Mesh(textGeometry, textMaterial);
        }

        const fontLoader = new FontLoader();
        const ttfLoader = new TTFLoader();
        // Cargar custom TTF font
        ttfLoader.load('/assets/fonts/DejaVuSansMono.ttf', (json) => {
            font = fontLoader.parse(json);

            mesh1 = createText('Salvador', 40, font)
            mesh2 = createText('Web Developer', 24, font)
            mesh1.position.set(100, 80, 150);
            mesh2.position.set(100, 40, 150);
            scene.add(mesh1);
            scene.add(mesh2);
        });

        const light = new THREE.DirectionalLight(0xffffff, 1);
        light.position.set(5, 5, 5);
        scene.add(light);

        const raycaster = new THREE.Raycaster();
        const mouse = new THREE.Vector2();

        renderer.domElement.addEventListener("mousemove", (event) => {
            pixelMaterial.uniforms.mouse.value.set(
                event.clientX / document.documentElement.clientWidth,
                1-event.clientY / window.innerHeight
            );

            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

            light.position.x = mouse.x * 10;
            light.position.y = mouse.y * 10;
        });

        function animate() {
            requestAnimationFrame(animate);

            let elapsed = clock.getElapsedTime();
            pixelMaterial.uniforms.u_time.value = elapsed;
            renderer.render(scene, camera);
            //stats.update();

            // Si ya inicializaron las fonts
            if (mesh1 && mesh2) {

                // Actualizar el raycaster
                raycaster.setFromCamera(mouse, camera);
                mesh1.rotation.y = Math.sin(elapsed/1.8) / 3.5; // Vaivén en eje x
                mesh2.rotation.y = Math.sin(elapsed/1.8) / 3.5; // Vaivén en eje x
                mesh1.rotation.z = Math.sin(elapsed/1.8) / 10; // Vaivén en eje x
                mesh2.rotation.z = Math.sin(elapsed/1.8) / 10; // Vaivén en eje x

                // Detectar intersecciones
                const intersects1 = raycaster.intersectObject(mesh1);
                const intersects2 = raycaster.intersectObject(mesh2);

                if (intersects1.length > 0 || intersects2.length > 0) {
                  // Restaurar el estado original
                    mesh1.material.color.set('lime');
                    mesh2.material.color.set('lime');
                } else {
                // Cambiar color o escalar el texto cuando está en hover
                mesh1.material.color.set('white');
                mesh2.material.color.set('white');
                }
            }
        }
        animate();

        window.addEventListener('resize', function() {
            camera.aspect = document.documentElement.clientWidth / window.innerHeight;
            camera.updateProjectionMatrix();

            renderer.setSize(
                document.documentElement.clientWidth,
                window.innerHeight
            );
            pixelMaterial.uniforms.resolution.value.set(
                document.documentElement.clientWidth,
                window.innerHeight
            );
        })

        return () => {
            if (refContainer.current)
              refContainer.current.removeChild(renderer.domElement);
        };
    }, [])

    return (
        <div>
            <div ref={refContainer}></div>
            <video id="dockerscript-video" style={{display: "none"}} autoPlay loop muted>
                <source src="/assets/docker-restart.webm" />
            </video>
        </div>
    );
}
