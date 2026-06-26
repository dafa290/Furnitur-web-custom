@extends('layouts.app')

@section('title', 'Custom Furniture | FurniNest')

@section('content')
<style>
    .customizer-container {
        display: flex;
        height: calc(100vh - 80px);
        background: #f8f9fa;
        overflow: hidden;
    }

    #canvas-container {
        flex: 1;
        position: relative;
        background: radial-gradient(circle, #ffffff 0%, #e0e0e0 100%);
    }

    .controls-panel {
        width: 350px;
        background: white;
        padding: 30px;
        box-shadow: -5px 0 15px rgba(0,0,0,0.05);
        overflow-y: auto;
        z-index: 10;
    }

    .control-group {
        margin-bottom: 25px;
    }

    .control-group h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 8px;
    }

    .control-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.9rem;
        margin-bottom: 8px;
        color: #666;
    }

    input[type="range"] {
        width: 100%;
        accent-color: #d4af37;
    }

    .color-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }

    .color-option {
        width: 100%;
        padding-top: 100%;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: transform 0.2s, border-color 0.2s;
    }

    .color-option:hover {
        transform: scale(1.1);
    }

    .color-option.active {
        border-color: #d4af37;
    }

    .btn-save {
        width: 100%;
        padding: 15px;
        background: #1a1a1a;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
        transition: background 0.3s;
    }

    .btn-save:hover {
        background: #333;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: white;
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 100;
        transition: opacity 0.5s;
    }

    .loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #d4af37;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="customizer-container">
    <div id="canvas-container">
        <div id="loading" class="loading-overlay">
            <div class="loader"></div>
        </div>
    </div>

    <div class="controls-panel">
        <h2 style="font-family: 'Playfair Display', serif; margin-bottom: 20px;">Custom Wardrobe</h2>
        
        <div class="control-group">
            <h3>Tipe Furnitur</h3>
            <select id="furniture-type" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd; font-weight: 600;">
                <option value="wardrobe">Lemari Pakaian</option>
                <option value="bed">Tempat Tidur (Bed)</option>
                <option value="chair">Kursi Makan</option>
                <option value="table">Meja Kerja</option>
            </select>
        </div>

        <div class="control-group">
            <h3>Dimensi (cm)</h3>
            <div class="control-label">
                <span>Lebar</span>
                <span id="width-val">120 cm</span>
            </div>
            <input type="range" id="width-range" min="40" max="240" value="120">
            
            <div class="control-label" style="margin-top: 15px;">
                <span>Tinggi</span>
                <span id="height-val">200 cm</span>
            </div>
            <input type="range" id="height-range" min="40" max="260" value="200">
            
            <div class="control-label" style="margin-top: 15px;">
                <span>Kedalaman</span>
                <span id="depth-val">40 cm</span>
            </div>
            <input type="range" id="depth-range" min="40" max="200" value="60">
        </div>

        <div class="control-group" id="door-config-group">
            <h3>Konfigurasi Pintu</h3>
            <select id="door-config" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ddd;">
                <option value="2">2 Pintu Swing</option>
                <option value="3">3 Pintu Swing</option>
                <option value="4">4 Pintu Swing</option>
            </select>
        </div>

        <div class="control-group">
            <h3>Material & Warna</h3>
            <div class="color-grid">
                <div class="color-option active" style="background: #5d4037;" data-color="#5d4037" title="Oak"></div>
                <div class="color-option" style="background: #3e2723;" data-color="#3e2723" title="Mahogany"></div>
                <div class="color-option" style="background: #f5f5f5;" data-color="#f5f5f5" title="White Gloss"></div>
                <div class="color-option" style="background: #212121;" data-color="#212121" title="Matte Black"></div>
                <div class="color-option" style="background: #a1887f;" data-color="#a1887f" title="Light Wood"></div>
                <div class="color-option" style="background: #795548;" data-color="#795548" title="Walnut"></div>
            </div>
        </div>

        <div style="background: #f0f0f0; padding: 20px; border-radius: 8px; margin-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 600; color: #666;">Estimasi Harga:</span>
                <span id="price-display" style="font-size: 1.4rem; font-weight: 700; color: #1a1a1a;">Rp 4.500.000</span>
            </div>
        </div>

        <button class="btn-save" onclick="saveConfiguration()">Tambahkan ke Keranjang</button>
    </div>
</div>

<!-- Three.js and OrbitControls from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<script>
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
        camera = new THREE.PerspectiveCamera(45, (window.innerWidth - 350) / (window.innerHeight - 80), 0.1, 1000);
        camera.position.set(3, 2, 4);

        // Renderer setup
        renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(window.innerWidth - 350, window.innerHeight - 80);
        renderer.shadowMap.enabled = true;
        document.getElementById('canvas-container').appendChild(renderer.domElement);

        // Controls (Ensure THREE namespace is used)
        if (typeof THREE.OrbitControls === 'undefined') {
            if (typeof OrbitControls !== 'undefined') {
                THREE.OrbitControls = OrbitControls;
            }
        }
        
        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.minDistance = 2;
        controls.maxDistance = 10;
        controls.target.set(0, 1, 0);

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
        
        // Set default dimensions based on type
        if (config.type === 'bed') { config.width = 1.6; config.height = 0.5; config.depth = 2.0; }
        else if (config.type === 'chair') { config.width = 0.5; config.height = 0.9; config.depth = 0.5; }
        else if (config.type === 'table') { config.width = 1.2; config.height = 0.75; config.depth = 0.6; }
        else { config.width = 1.2; config.height = 2.0; config.depth = 0.6; }

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
        camera.aspect = (window.innerWidth - 350) / (window.innerHeight - 80);
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth - 350, window.innerHeight - 80);
    });

    window.onload = init;
</script>
@endsection
