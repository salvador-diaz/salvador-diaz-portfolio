import { useState, useEffect, useRef } from 'react'
import * as THREE from 'three'; // npm install three

import {OrbitControls} from 'three/examples/jsm/controls/OrbitControls.js';
import Stats from 'three/addons/libs/stats.module.js';

export default function TestPixelate() {
   const refContainer = useRef(null);
    useEffect(() => {

        // Renderer, se encarga del canvas
        const renderer = new THREE.WebGLRenderer();
        renderer.setSize(
            document.documentElement.clientWidth,
            window.innerHeight
        );
        // Añadir al HTML
        refContainer.current.appendChild(renderer.domElement);


        const scene = new THREE.Scene();
        // Usamos ortográfica para que no se tome en cuenta la distancia de la camara.
        const camera = new THREE.OrthographicCamera(
            document.documentElement.clientWidth / -2, document.documentElement.clientWidth / 2,
            window.innerHeight / 2, window.innerHeight / -2, 
            0.1, // near render limit
            1000 // far render limit
        );
        camera.position.z = 1; // igual hay que setear z

        // permite mover y girar la camara. SIrve mucho como debug
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
        const texture = new THREE.TextureLoader().load("src/assets/cat.jpg");
        const pixelShader = {
          uniforms: {
            tDiffuse: {value: texture},                     // La textura de la imagen
            resolution: {value: new THREE.Vector2(document.documentElement.clientWidth, window.innerHeight)}, // Resolución de la pantalla
            pixelSize: {value: 8.0},                        // Tamaño de cada píxel
            radius: {value: 0.11},                          // Radio de pixelación normalizado
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
                float noiseFactor = noise(vUv * 10.0 + u_time * 0.8) * 0.2; // (Posición * suavizado_ruido + tiempo * velocidad) * distorsion en borde
                // Cambiar el radio del borde usando el ruido
                float distortedRadius = radius + noiseFactor;

                // Animación para agrandar/achicar radio. sin(tiempo * velocidad_de_variacion) * amplitud radio
                //float animatedRadius = radius + sin(u_time * 2.) * 0.05; // seno oscila entre 1 y -1
                //float smoothFactor = smoothstep(animatedRadius, animatedRadius - 0.03, dist);

                // Factir de suavizado del borde
                float smoothness = 0.07; 
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

        renderer.domElement.addEventListener("mousemove", (event) => {
            pixelMaterial.uniforms.mouse.value.set(
                event.clientX / document.documentElement.clientWidth,
                1-event.clientY / window.innerHeight
            );

        });

        function animate() {
            requestAnimationFrame(animate);

            pixelMaterial.uniforms.u_time.value = clock.getElapsedTime();
            renderer.render(scene, camera);
            //stats.update();
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
          refContainer.current.removeChild(renderer.domElement);
        };
    }, [])

    return (
        <div ref={refContainer}></div>
    );
}
