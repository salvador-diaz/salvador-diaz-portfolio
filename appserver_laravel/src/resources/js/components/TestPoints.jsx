import { useState, useEffect, useRef } from 'react'
import * as THREE from 'three'; // npm install three

export default function TestPoints() {
   const refContainer = useRef(null);
    useEffect(() => {
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(
            75, // FOV (Field Of View) qué tantos grados se ven
            document.documentElement.clientWidth / window.innerHeight, // Aspect ratio
            0.1, // near render limit
            1000 // far render limit
        );
        camera.position.z = 3;

        // Renderer
        const renderer = new THREE.WebGLRenderer();
        // Tamaño del canvas
        renderer.setSize(
            document.documentElement.clientWidth,
            window.innerHeight
        );
        refContainer.current.appendChild( renderer.domElement );
        window.addEventListener('resize', function() {
            camera.aspect = document.documentElement.clientWidth / window.innerHeight;
            camera.updateProjectionMatrix();

            renderer.setSize(
                document.documentElement.clientWidth,
                window.innerHeight
            );
        })

        // Geometria, material y mesh del plano
        var planeGeometry = new THREE.PlaneGeometry(10, 10);
        const planeMaterial = new THREE.MeshBasicMaterial({color: 0xffff00, side: THREE.DoubleSide})//{ visible: true });
        var plane = new THREE.Mesh(planeGeometry, planeMaterial);

        scene.add(plane);

        // Crear geometría para un solo punto
        const pointGeometry = new THREE.BufferGeometry();
        const positions = new Float32Array([0.0, 0.0, 0.0]); // Inicia en el origen
        pointGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        const pointMaterial = new THREE.ShaderMaterial( {
            uniforms: {
                size: { value: 10.0 }, // Tamaño del punto
                color: { value: new THREE.Color(0xff0000) } // rojo
            },
            vertexShader: `
                void main() {
                    gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.);
                    gl_PointSize = 10.;
                }
            `,
            fragmentShader: `
                uniform vec3 color;
                void main() {
                    gl_FragColor = vec4(color, 1.);
                }
            `
        });
        // Crear el objeto de puntos
        const point = new THREE.Points(pointGeometry, pointMaterial);
        // Añadir a la escena
        scene.add(point);

        const sceneCursor = new THREE.Vector2();
        const raycaster = new THREE.Raycaster();

        renderer.domElement.addEventListener("mousemove", (event) => {
            sceneCursor.x = ( event.clientX / document.documentElement.clientWidth ) * 2 - 1;
            sceneCursor.y = - ( event.clientY / window.innerHeight ) * 2 + 1;
            //console.log(sceneCursor.x, sceneCursor.y)
        });

        //console.log(camera.getWorldDirection(new THREE.Vector3()));
        //console.log(camera.matrixWorld);

        function animate() {
            requestAnimationFrame(animate);

            // Actualizar la posición del punto según el mouse
            raycaster.setFromCamera(sceneCursor, camera);
            const intersects = raycaster.intersectObject(plane);

            if (intersects.length > 0) {
              const intersect = intersects[0];
              point.position.copy(intersect.point);
            }

            renderer.render(scene, camera);
        }
        animate();

        return () => {
          refContainer.current.removeChild(renderer.domElement);
        };
    }, [])

    return (
        <div ref={refContainer}></div>
    );
}
