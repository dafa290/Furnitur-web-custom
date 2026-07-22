let scene, camera, renderer, controls;
let wardrobeGroup, body, doors = [], handles = [];
let currentMaterial;

const config = {
    type: 'wardrobe',
    width: 1.2,
    height: 2.0,
    depth: 0.6,
    color: '#5d4037',
    doorCount: 2,
    price: 4500000
};

function init() {
    // Scene setup
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf8f9fa);

    // Camera setup
    const container = document.getElementById('canvas-container');
    camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.set(3, 2, 4);

    // Renderer setup
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.shadowMap.enabled = true;
    container.appendChild(renderer.domElement);

    // Controls (Ensure THREE namespace is used)
    if (typeof THREE.OrbitControls === 'undefined') {
        if (typeof OrbitControls !== 'undefined') {
            THREE.OrbitControls = OrbitControls;
        }
    }
    
    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.enableZoom = true;
    controls.enablePan = true;
    controls.enableRotate = true;
    controls.minDistance = 1; // Allow zooming in closer
    controls.maxDistance = 20; // Allow zooming out further
    controls.target.set(0, 1, 0);
    controls.update(); // Initialize target

    // Lights
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(5, 10, 7);
    directionalLight.castShadow = true;
    scene.add(directionalLight);

    const pointLight = new THREE.PointLight(0xffffff, 0.5);
    pointLight.position.set(-5, 5, -5);
    scene.add(pointLight);

    // Floor
    const floorGeometry = new THREE.PlaneGeometry(10, 10);
    const floorMaterial = new THREE.MeshStandardMaterial({ color: 0xeeeeee });
    const floor = new THREE.Mesh(floorGeometry, floorMaterial);
    floor.rotation.x = -Math.PI / 2;
    floor.receiveShadow = true;
    scene.add(floor);

    // Grid
    const grid = new THREE.GridHelper(10, 20, 0xcccccc, 0xdddddd);
    scene.add(grid);

    // Create initial furniture
    createFurniture();

    // Loading finished
    setTimeout(() => {
        const loading = document.getElementById('loading');
        if (loading) {
            loading.style.opacity = '0';
            setTimeout(() => { loading.style.display = 'none'; }, 500);
        }
    }, 500);

    animate();
}

function animate() {
    requestAnimationFrame(animate);
    if (controls) controls.update();
    renderer.render(scene, camera);
}

function createFurniture() {
    if (wardrobeGroup) scene.remove(wardrobeGroup);
    wardrobeGroup = new THREE.Group();
    doors = [];
    handles = [];

    const woodMaterial = new THREE.MeshStandardMaterial({ 
        color: config.color,
        roughness: 0.7,
        metalness: 0.1
    });

    if (config.type === 'wardrobe') {
        createWardrobeModel(woodMaterial);
    } else if (config.type === 'bed') {
        createBedModel(woodMaterial);
    } else if (config.type === 'chair') {
        createChairModel(woodMaterial);
    } else if (config.type === 'table') {
        createTableModel(woodMaterial);
    }

    scene.add(wardrobeGroup);
    updatePrice();
}

function createWardrobeModel(mat) {
    // Body
    const bodyGeo = new THREE.BoxGeometry(config.width, config.height, config.depth);
    const bodyMesh = new THREE.Mesh(bodyGeo, mat);
    bodyMesh.position.y = config.height / 2;
    bodyMesh.castShadow = true;
    wardrobeGroup.add(bodyMesh);

    // Doors
    const doorWidth = config.width / config.doorCount;
    const handleMat = new THREE.MeshStandardMaterial({ color: 0xcccccc, metalness: 0.8 });
    for (let i = 0; i < config.doorCount; i++) {
        const doorGeo = new THREE.BoxGeometry(doorWidth - 0.01, config.height - 0.05, 0.02);
        const door = new THREE.Mesh(doorGeo, mat);
        const xOff = (i - (config.doorCount - 1) / 2) * doorWidth;
        door.position.set(xOff, config.height / 2, config.depth / 2 + 0.01);
        wardrobeGroup.add(door);

        const hGeo = new THREE.CylinderGeometry(0.01, 0.01, 0.2);
        const h = new THREE.Mesh(hGeo, handleMat);
        h.position.set(xOff + (doorWidth/3 * ((i%2==0)?1:-1)), config.height/2, config.depth/2 + 0.03);
        wardrobeGroup.add(h);
    }
}

function createBedModel(mat) {
    // Frame
    const frameGeo = new THREE.BoxGeometry(config.width, 0.3, config.depth);
    const frame = new THREE.Mesh(frameGeo, mat);
    frame.position.y = 0.15;
    wardrobeGroup.add(frame);

    // Mattress
    const mattressGeo = new THREE.BoxGeometry(config.width - 0.05, 0.2, config.depth - 0.05);
    const mattressMat = new THREE.MeshStandardMaterial({ color: 0xfffffff });
    const mattress = new THREE.Mesh(mattressGeo, mattressMat);
    mattress.position.y = 0.35;
    wardrobeGroup.add(mattress);

    // Headboard
    const hbGeo = new THREE.BoxGeometry(config.width, config.height * 0.5, 0.1);
    const hb = new THREE.Mesh(hbGeo, mat);
    hb.position.set(0, (config.height * 0.5) / 2, -config.depth / 2 + 0.05);
    wardrobeGroup.add(hb);
}

function createChairModel(mat) {
    // Seat
    const seatGeo = new THREE.BoxGeometry(config.width, 0.05, config.depth);
    const seat = new THREE.Mesh(seatGeo, mat);
    seat.position.y = 0.5;
    wardrobeGroup.add(seat);

    // Legs
    const legGeo = new THREE.CylinderGeometry(0.02, 0.02, 0.5);
    const legPositions = [
        [config.width/2-0.05, 0.25, config.depth/2-0.05],
        [-config.width/2+0.05, 0.25, config.depth/2-0.05],
        [config.width/2-0.05, 0.25, -config.depth/2+0.05],
        [-config.width/2+0.05, 0.25, -config.depth/2+0.05]
    ];
    legPositions.forEach(p => {
        const leg = new THREE.Mesh(legGeo, mat);
        leg.position.set(...p);
        wardrobeGroup.add(leg);
    });

    // Backrest
    const backGeo = new THREE.BoxGeometry(config.width, config.height - 0.5, 0.05);
    const back = new THREE.Mesh(backGeo, mat);
    back.position.set(0, 0.5 + (config.height - 0.5)/2, -config.depth/2 + 0.02);
    wardrobeGroup.add(back);
}

function createTableModel(mat) {
    // Top
    const topGeo = new THREE.BoxGeometry(config.width, 0.04, config.depth);
    const top = new THREE.Mesh(topGeo, mat);
    top.position.y = config.height;
    wardrobeGroup.add(top);

    // Legs
    const legGeo = new THREE.BoxGeometry(0.05, config.height, 0.05);
    const legPositions = [
        [config.width/2-0.05, config.height/2, config.depth/2-0.05],
        [-config.width/2+0.05, config.height/2, config.depth/2-0.05],
        [config.width/2-0.05, config.height/2, -config.depth/2+0.05],
        [-config.width/2+0.05, config.height/2, -config.depth/2+0.05]
    ];
    legPositions.forEach(p => {
        const leg = new THREE.Mesh(legGeo, mat);
        leg.position.set(...p);
        wardrobeGroup.add(leg);
    });
}

function updatePrice() {
    // Base prices
    const basePrice = {
        wardrobe: 2000000,
        bed: 3000000,
        chair: 500000,
        table: 1200000
    };

    // Volume factor (Price per cubic meter)
    const volumeFactor = 5000000;
    const volume = config.width * config.height * config.depth;
    
    // Complexity factor
    let complexity = 1;
    if (config.type === 'wardrobe') complexity += (config.doorCount * 0.1);
    
    config.price = Math.round((basePrice[config.type] + (volume * volumeFactor)) * complexity);
    
    // Formatting
    const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(config.price);
    document.getElementById('price-display').innerText = formatted;
}

// Input Listeners
document.getElementById('furniture-type').addEventListener('change', (e) => {
    config.type = e.target.value;
    const doorGroup = document.getElementById('door-config-group');
    doorGroup.style.display = (config.type === 'wardrobe') ? 'block' : 'none';
    
    // Set default dimensions and dynamic slider limits based on type
    const widthRange = document.getElementById('width-range');
    const heightRange = document.getElementById('height-range');
    const depthRange = document.getElementById('depth-range');

    if (config.type === 'bed') { 
        config.width = 1.6; config.height = 0.5; config.depth = 2.0; 
        widthRange.min = 90; widthRange.max = 220;
        heightRange.min = 20; heightRange.max = 80;
        depthRange.min = 190; depthRange.max = 220;
    }
    else if (config.type === 'chair') { 
        config.width = 0.5; config.height = 0.9; config.depth = 0.5; 
        widthRange.min = 40; widthRange.max = 80;
        heightRange.min = 40; heightRange.max = 130;
        depthRange.min = 40; depthRange.max = 80;
    }
    else if (config.type === 'table') { 
        config.width = 1.2; config.height = 0.75; config.depth = 0.6; 
        widthRange.min = 60; widthRange.max = 240;
        heightRange.min = 40; heightRange.max = 120;
        depthRange.min = 40; depthRange.max = 120;
    }
    else { // wardrobe
        config.width = 1.2; config.height = 2.0; config.depth = 0.6; 
        widthRange.min = 40; widthRange.max = 300;
        heightRange.min = 100; heightRange.max = 250;
        depthRange.min = 30; depthRange.max = 100;
    }

    updateUIFromConfig();
    createFurniture();
});

function updateUIFromConfig() {
    document.getElementById('width-range').value = config.width * 100;
    document.getElementById('height-range').value = config.height * 100;
    document.getElementById('depth-range').value = config.depth * 100;
    document.getElementById('width-val').innerText = Math.round(config.width * 100) + ' cm';
    document.getElementById('height-val').innerText = Math.round(config.height * 100) + ' cm';
    document.getElementById('depth-val').innerText = Math.round(config.depth * 100) + ' cm';
}

document.getElementById('width-range').addEventListener('input', (e) => {
    config.width = e.target.value / 100;
    document.getElementById('width-val').innerText = e.target.value + ' cm';
    createFurniture();
});

document.getElementById('height-range').addEventListener('input', (e) => {
    config.height = e.target.value / 100;
    document.getElementById('height-val').innerText = e.target.value + ' cm';
    createFurniture();
});

document.getElementById('depth-range').addEventListener('input', (e) => {
    config.depth = e.target.value / 100;
    document.getElementById('depth-val').innerText = e.target.value + ' cm';
    createFurniture();
});

document.querySelectorAll('.color-option').forEach(opt => {
    opt.addEventListener('click', (e) => {
        document.querySelector('.color-option.active').classList.remove('active');
        e.target.classList.add('active');
        config.color = e.target.dataset.color;
        createFurniture();
    });
});

document.getElementById('door-config').addEventListener('change', (e) => {
    config.doorCount = parseInt(e.target.value);
    createFurniture();
});

function saveConfiguration() {
    const typeLabels = { wardrobe: 'Lemari', bed: 'Kasur', chair: 'Kursi', table: 'Meja' };
    const dimensions = `${Math.round(config.width * 100)}x${Math.round(config.height * 100)}x${Math.round(config.depth * 100)}cm`;
    const colorName = document.querySelector('.color-option.active').title;
    const productName = `Custom ${typeLabels[config.type]} (${dimensions}, ${colorName})`;
    
    const payload = {
        id: 1000 + Math.floor(Math.random() * 1000), // Random ID untuk produk custom
        name: productName,
        price: config.price,
        img: 'https://images.unsplash.com/photo-1595428774223-ef52624120d2?w=500', 
        quantity: 1
    };

    fetch('/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) { window.location.href = '/checkout'; }
        else { alert('Gagal: ' + (data.error || 'Login dulu ya!')); }
    })
    .catch(() => alert('Terjadi kesalahan koneksi.'));
}

window.addEventListener('resize', () => {
    const container = document.getElementById('canvas-container');
    if(container && camera && renderer) {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);
    }
});

window.onload = init;
