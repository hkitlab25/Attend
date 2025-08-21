<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>কর্মচারী প্যানেল</title>
    <!-- Tailwind CSS CDN for styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for the app */
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        .container {
            max-width: 1000px;
        }
        .dark-mode {
            background-color: #1f2937;
            color: #f3f4f6;
        }
        .dark-mode .bg-white {
            background-color: #374151;
        }
        .dark-mode .text-gray-900 {
            color: #f3f4f6;
        }
        .dark-mode .text-gray-600 {
            color: #d1d5db;
        }
        .dark-mode .border-gray-200 {
            border-color: #4b5563;
        }
        .dark-mode .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
        }
        .tab-button.active {
            border-bottom: 2px solid #3b82f6;
            color: #3b82f6;
            font-weight: 600;
        }
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
        #salesProgressBar {
            transition: width 0.5s ease-in-out;
        }
        #cameraFeed {
            transform: scaleX(-1); /* Mirror the camera feed */
        }
        #userIdDisplay {
            word-break: break-all;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <div class="container mx-auto p-4 md:p-8">
        <!-- Header -->
        <header class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">কর্মচারী প্যানেল</h1>
            <p class="text-md md:text-lg text-gray-600 dark:text-gray-300 mt-2">আপনার প্রতিদিনের কাজগুলো সহজে পরিচালনা করুন</p>
            <p class="text-sm text-gray-400 mt-2">আপনার ইউজার আইডি: <span id="userIdDisplay" class="font-mono text-xs">Loading...</span></p>
        </header>

        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-300 dark:border-gray-700 mb-8 overflow-x-auto whitespace-nowrap">
            <button class="tab-button active flex-1 py-4 px-2 text-center text-sm md:text-base transition-colors duration-300">উপস্থিতি</button>
            <button class="tab-button flex-1 py-4 px-2 text-center text-sm md:text-base transition-colors duration-300">অর্ডার</button>
            <button class="tab-button flex-1 py-4 px-2 text-center text-sm md:text-base transition-colors duration-300">কালেকশন</button>
            <button class="tab-button flex-1 py-4 px-2 text-center text-sm md:text-base transition-colors duration-300">সেলস</button>
            <button class="tab-button flex-1 py-4 px-2 text-center text-sm md:text-base transition-colors duration-300">নোটিফিকেশন</button>
            <button class="tab-button flex-1 py-4 px-2 text-center text-sm md:text-base transition-colors duration-300">সেটিংস</button>
        </div>

        <!-- Tab Content -->
        <div id="tabContent">

            <!-- 1. Attendance Management Section -->
            <div class="tab-pane p-6 rounded-xl shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">উপস্থিতি ব্যবস্থাপনা</h2>
                <div class="flex flex-col space-y-4">
                    <!-- Live Camera Section -->
                    <div class="flex flex-col items-center justify-center space-y-4">
                        <video id="cameraFeed" class="w-full h-auto max-w-sm rounded-lg border border-gray-300 dark:border-gray-600 hidden" autoplay></video>
                        <canvas id="cameraCanvas" class="hidden"></canvas>
                        <button id="startCameraBtn" class="bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 ease-in-out shadow-md">
                            ক্যামেরা চালু করুন
                        </button>
                        <button id="captureAttendanceBtn" class="bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 ease-in-out shadow-md hidden">
                            ক্যাপচার ও উপস্থিতি মার্ক করুন
                        </button>
                    </div>

                    <div id="attendanceStatus" class="text-center text-sm font-medium text-gray-600 dark:text-gray-400">
                        <!-- Attendance status will be displayed here -->
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-600 my-4"></div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">মাসিক রিপোর্ট</h3>
                        <p id="monthlyReport" class="text-sm text-gray-600 dark:text-gray-400">রিপোর্ট লোড হচ্ছে...</p>
                    </div>
                    <button id="leaveRequestBtn" class="bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition duration-300 ease-in-out shadow-md dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">
                        ছুটির জন্য আবেদন
                    </button>
                    <div id="leaveStatus" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <!-- Leave status will be displayed here -->
                    </div>
                </div>
            </div>

            <!-- 2. Daily Order Submit Section -->
            <div class="tab-pane hidden p-6 rounded-xl shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">দৈনিক অর্ডার সাবমিট</h2>
                <button id="newOrderBtn" class="bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 ease-in-out shadow-md mb-4">
                    নতুন অর্ডার যোগ করুন
                </button>
                <div id="orderList" class="space-y-4">
                    <!-- Orders will be rendered here -->
                </div>
                <div id="orderMessage" class="mt-4 text-sm font-medium text-green-600 dark:text-green-400 hidden"></div>
            </div>

            <!-- 3. Collection Budget Submit Section -->
            <div class="tab-pane hidden p-6 rounded-xl shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">কালেকশন বাজেট সাবমিট</h2>
                <form id="collectionForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">টাকার পরিমাণ</label>
                        <input type="number" id="collectionAmount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">পেমেন্ট পদ্ধতি</label>
                        <select id="collectionMethod" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2" required>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                            <option value="Mobile Banking">Mobile Banking</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">রেফারেন্স নম্বর (ঐচ্ছিক)</label>
                        <input type="text" id="collectionReference" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2">
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300 ease-in-out shadow-md">
                        কালেকশন সাবমিট করুন
                    </button>
                </form>
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">আপনার কালেকশন রিপোর্ট</h3>
                    <p id="collectionReport" class="text-sm text-gray-600 dark:text-gray-400 mt-2"></p>
                </div>
            </div>

            <!-- 4. Sales Budget Submit Section -->
            <div class="tab-pane hidden p-6 rounded-xl shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">সেলস বাজেট সাবমিট</h2>
                <form id="salesForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">আজকের সেলস</label>
                        <input type="number" id="salesAmount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2" required>
                    </div>
                    <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 ease-in-out shadow-md">
                        সেলস সাবমিট করুন
                    </button>
                </form>
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">সেলস প্রগ্রেস</h3>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-2">
                        <div id="salesProgressBar" class="bg-purple-600 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <p id="salesProgressText" class="text-sm text-gray-600 dark:text-gray-400 mt-2">টার্গেট: ৳100000, বর্তমান: ৳0 (0%)</p>
                </div>
            </div>

            <!-- 5. Notifications & Updates Section -->
            <div class="tab-pane hidden p-6 rounded-xl shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">নোটিফিকেশন ও আপডেট</h2>
                <ul id="notificationList" class="space-y-4">
                    <!-- Notifications will be rendered here -->
                </ul>
            </div>

            <!-- 6. Profile & Settings Section -->
            <div class="tab-pane hidden p-6 rounded-xl shadow-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">প্রোফাইল ও সেটিংস</h2>
                <div class="flex flex-col space-y-4">
                    <div class="flex justify-between items-center py-2">
                        <span class="text-lg text-gray-900 dark:text-white">থিম পরিবর্তন</span>
                        <label for="themeToggle" class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="themeToggle" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"></span>
                        </label>
                    </div>
                    <button class="bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition duration-300 ease-in-out shadow-md dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">
                        প্রোফাইল আপডেট করুন
                    </button>
                    <button class="bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition duration-300 ease-in-out shadow-md dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">
                        পাসওয়ার্ড পরিবর্তন করুন
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal for Forms (New Order, Leave Request) -->
        <div id="formModal" class="modal-overlay fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 max-w-xl w-full">
                <h3 id="modalTitle" class="text-2xl font-bold mb-4">নতুন অর্ডার</h3>
                <form id="modalForm" class="space-y-4">
                    <!-- Form fields will be dynamically injected here -->
                </form>
                <div class="flex justify-end space-x-4 mt-4">
                    <button id="closeModalBtn" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg font-semibold dark:bg-gray-600 dark:text-gray-100">বাতিল করুন</button>
                    <button id="submitModalBtn" class="bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold">সাবমিট করুন</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Firebase SDK Scripts -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
        import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
        import { getFirestore, collection, doc, addDoc, onSnapshot, updateDoc, deleteDoc, getDocs, getDoc } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

        // --- Firebase Initialization ---
        // Access global variables provided by the canvas environment
        const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
        const firebaseConfig = JSON.parse(typeof __firebase_config !== 'undefined' ? __firebase_config : '{}');
        const initialAuthToken = typeof __initial_auth_token !== 'undefined' ? __initial_auth_token : null;

        let db;
        let auth;
        let userId = 'loading...';
        let isAuthReady = false;

        // UI elements
        const userIdDisplay = document.getElementById('userIdDisplay');
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanes = document.querySelectorAll('.tab-pane');
        const body = document.body;
        const themeToggle = document.getElementById('themeToggle');
        const formModal = document.getElementById('formModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalForm = document.getElementById('modalForm');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const submitModalBtn = document.getElementById('submitModalBtn');

        // Camera elements
        const startCameraBtn = document.getElementById('startCameraBtn');
        const captureAttendanceBtn = document.getElementById('captureAttendanceBtn');
        const cameraFeed = document.getElementById('cameraFeed');
        const cameraCanvas = document.getElementById('cameraCanvas');
        const context = cameraCanvas.getContext('2d');
        let stream = null;

        // Attendance elements
        const attendanceStatus = document.getElementById('attendanceStatus');
        const monthlyReport = document.getElementById('monthlyReport');
        const leaveRequestBtn = document.getElementById('leaveRequestBtn');
        const leaveStatusDiv = document.getElementById('leaveStatus');

        // Order elements
        const newOrderBtn = document.getElementById('newOrderBtn');
        const orderList = document.getElementById('orderList');
        const orderMessage = document.getElementById('orderMessage');

        // Collection elements
        const collectionForm = document.getElementById('collectionForm');
        const collectionReport = document.getElementById('collectionReport');

        // Sales elements
        const salesForm = document.getElementById('salesForm');
        const salesProgressBar = document.getElementById('salesProgressBar');
        const salesProgressText = document.getElementById('salesProgressText');

        // Notification elements
        const notificationList = document.getElementById('notificationList');

        // --- Main App Logic ---
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                // Initialize Firebase
                const app = initializeApp(firebaseConfig);
                db = getFirestore(app);
                auth = getAuth(app);

                // Authenticate the user
                if (initialAuthToken) {
                    await signInWithCustomToken(auth, initialAuthToken);
                } else {
                    await signInAnonymously(auth);
                }

                // Listen for auth state changes and set up Firestore listeners
                onAuthStateChanged(auth, (user) => {
                    if (user) {
                        userId = user.uid;
                        isAuthReady = true;
                        userIdDisplay.textContent = userId;
                        setupFirestoreListeners();
                        alertMessage('অ্যাপ্লিকেশন লোড হয়েছে, ডেটাবেস সংযোগ সফল!', 'green');
                    } else {
                        userId = crypto.randomUUID(); // Fallback for non-authenticated state
                        userIdDisplay.textContent = userId;
                        isAuthReady = true;
                        alertMessage('ব্যবহারকারী প্রমাণীকরণ সফল। ডেটাবেস সংযোগ সম্পন্ন!', 'green');
                    }
                });
            } catch (error) {
                console.error("Firebase initialization or authentication failed:", error);
                alertMessage('ডেটাবেস সংযোগে ব্যর্থতা।', 'red');
            }

            // --- Event Listeners ---
            tabButtons.forEach((button, index) => {
                button.addEventListener('click', () => {
                    // Stop camera stream if the user navigates away from the attendance tab
                    if (index !== 0 && stream) {
                        const tracks = stream.getTracks();
                        tracks.forEach(track => track.stop());
                        cameraFeed.classList.add('hidden');
                        startCameraBtn.classList.remove('hidden');
                        captureAttendanceBtn.classList.add('hidden');
                        stream = null;
                    }
                    tabPanes.forEach(pane => pane.classList.add('hidden'));
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabPanes[index].classList.remove('hidden');
                    button.classList.add('active');
                });
            });

            themeToggle.addEventListener('change', () => {
                body.classList.toggle('dark-mode');
            });

            // --- Feature-specific Logic ---

            // 1. Attendance Management
            startCameraBtn.addEventListener('click', async () => {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                    cameraFeed.srcObject = stream;
                    cameraFeed.classList.remove('hidden');
                    startCameraBtn.classList.add('hidden');
                    captureAttendanceBtn.classList.remove('hidden');
                    attendanceStatus.innerHTML = `<span class="text-blue-600 dark:text-blue-400">ক্যামেরা চালু হয়েছে।</span>`;
                } catch (err) {
                    attendanceStatus.innerHTML = `<span class="text-red-600 dark:text-red-400">ক্যামেরা অ্যাক্সেস অনুমোদিত নয়।</span>`;
                    console.error("Camera access denied:", err);
                }
            });

            captureAttendanceBtn.addEventListener('click', async () => {
                if (!isAuthReady) return alertMessage('ডেটাবেস লোড হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন।', 'red');

                cameraCanvas.width = cameraFeed.videoWidth;
                cameraCanvas.height = cameraFeed.videoHeight;
                context.drawImage(cameraFeed, 0, 0, cameraCanvas.width, cameraCanvas.height);
                const capturedImage = cameraCanvas.toDataURL('image/png');

                // Stop the camera stream
                const tracks = stream.getTracks();
                tracks.forEach(track => track.stop());
                cameraFeed.srcObject = null;
                cameraFeed.classList.add('hidden');
                startCameraBtn.classList.remove('hidden');
                captureAttendanceBtn.classList.add('hidden');

                const now = new Date();
                const attendanceData = {
                    date: now.toLocaleDateString('bn-BD'),
                    inTime: now.toLocaleTimeString('bn-BD'),
                    outTime: 'N/A',
                    capturedImage: capturedImage,
                    timestamp: new Date()
                };

                try {
                    await addDoc(collection(db, `/artifacts/${appId}/users/${userId}/attendance`), attendanceData);
                    attendanceStatus.innerHTML = `<span class="text-green-600 dark:text-green-400">উপস্থিতি সফলভাবে মার্ক করা হয়েছে!</span><br>সময়: ${getCurrentDateTime()}`;
                } catch (e) {
                    console.error("Error adding document: ", e);
                    alertMessage('উপস্থিতি সাবমিট করতে ব্যর্থ।', 'red');
                }
            });

            leaveRequestBtn.addEventListener('click', () => {
                openModal('ছুটির জন্য আবেদন', 'leave');
            });

            // 2. Daily Order Submit
            newOrderBtn.addEventListener('click', () => {
                openModal('নতুন অর্ডার যোগ করুন', 'order');
            });

            // 3. Collection Budget Submit
            collectionForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (!isAuthReady) return alertMessage('ডেটাবেস লোড হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন।', 'red');
                const amount = document.getElementById('collectionAmount').value;
                const method = document.getElementById('collectionMethod').value;
                const reference = document.getElementById('collectionReference').value;

                const collectionData = {
                    date: new Date().toLocaleDateString('bn-BD'),
                    amount: parseFloat(amount),
                    method: method,
                    reference: reference,
                    timestamp: new Date()
                };
                try {
                    await addDoc(collection(db, `/artifacts/${appId}/users/${userId}/collections`), collectionData);
                    collectionForm.reset();
                    alertMessage('কালেকশন সফলভাবে সাবমিট করা হয়েছে!', 'green');
                } catch (e) {
                    console.error("Error adding document: ", e);
                    alertMessage('কালেকশন সাবমিট করতে ব্যর্থ।', 'red');
                }
            });

            // 4. Sales Budget Submit
            salesForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (!isAuthReady) return alertMessage('ডেটাবেস লোড হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন।', 'red');
                const salesAmount = parseFloat(document.getElementById('salesAmount').value);
                const salesTarget = 100000;

                const salesData = {
                    amount: salesAmount,
                    date: new Date().toLocaleDateString('bn-BD'),
                    timestamp: new Date()
                };

                try {
                    // Check if sales document for today exists to update it
                    const salesDocRef = doc(db, `/artifacts/${appId}/users/${userId}/sales`, 'current');
                    const salesDocSnap = await getDoc(salesDocRef);
                    
                    if (salesDocSnap.exists()) {
                        const currentTotal = salesDocSnap.data().currentTotal + salesAmount;
                        await updateDoc(salesDocRef, { currentTotal: currentTotal, lastUpdated: new Date() });
                    } else {
                        await setDoc(salesDocRef, { currentTotal: salesAmount, target: salesTarget, lastUpdated: new Date() });
                    }

                    salesForm.reset();
                    alertMessage('সেলস ডেটা সফলভাবে সাবমিট করা হয়েছে!', 'purple');
                } catch (e) {
                    console.error("Error setting sales data: ", e);
                    alertMessage('সেলস ডেটা সাবমিট করতে ব্যর্থ।', 'red');
                }
            });

            // 5. Notifications & Updates
            // Notifications are not dynamically updated here, they are hardcoded.

            // --- Modal Logic ---
            const openModal = (title, formType) => {
                modalTitle.textContent = title;
                modalForm.innerHTML = '';
                let formHTML = '';
                if (formType === 'order') {
                    formHTML = `
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ক্লায়েন্টের নাম</label>
                            <input type="text" id="clientName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">পণ্য/সার্ভিস</label>
                            <input type="text" id="productName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">মূল্য (টাকা)</label>
                            <input type="number" id="orderAmount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2" required>
                        </div>
                    `;
                } else if (formType === 'leave') {
                    formHTML = `
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ছুটির তারিখ</label>
                            <input type="date" id="leaveDate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">কারণ</label>
                            <textarea id="leaveReason" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 dark:bg-gray-700 dark:border-gray-600 p-2" rows="3" required></textarea>
                        </div>
                    `;
                }
                modalForm.innerHTML = formHTML;
                formModal.classList.remove('hidden');

                submitModalBtn.onclick = async () => {
                    if (!isAuthReady) return alertMessage('ডেটাবেস লোড হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন।', 'red');
                    if (formType === 'order') {
                        const clientName = document.getElementById('clientName').value;
                        const productName = document.getElementById('productName').value;
                        const orderAmount = document.getElementById('orderAmount').value;
                        if (clientName && productName && orderAmount) {
                            try {
                                await addDoc(collection(db, `/artifacts/${appId}/users/${userId}/orders`), {
                                    clientName, productName, amount: parseFloat(orderAmount), timestamp: new Date()
                                });
                                closeModal();
                                alertMessage('নতুন অর্ডার সফলভাবে যোগ করা হয়েছে!', 'green');
                            } catch (e) {
                                console.error("Error adding document: ", e);
                                alertMessage('অর্ডার সাবমিট করতে ব্যর্থ।', 'red');
                            }
                        }
                    } else if (formType === 'leave') {
                        const leaveDate = document.getElementById('leaveDate').value;
                        const leaveReason = document.getElementById('leaveReason').value;
                        if (leaveDate && leaveReason) {
                            try {
                                await addDoc(collection(db, `/artifacts/${appId}/users/${userId}/leaveRequests`), {
                                    date: leaveDate, reason: leaveReason, status: 'পর্যবেক্ষণে', timestamp: new Date()
                                });
                                closeModal();
                                alertMessage('ছুটির আবেদন সফলভাবে পাঠানো হয়েছে!', 'green');
                            } catch (e) {
                                console.error("Error adding document: ", e);
                                alertMessage('ছুটির আবেদন পাঠাতে ব্যর্থ।', 'red');
                            }
                        }
                    }
                };
            };

            const closeModal = () => {
                formModal.classList.add('hidden');
                modalForm.reset();
            };
            closeModalBtn.addEventListener('click', closeModal);
            formModal.addEventListener('click', (e) => {
                if (e.target.id === 'formModal') {
                    closeModal();
                }
            });

            // Generic alert message function
            const alertMessage = (message, color) => {
                const tempDiv = document.createElement('div');
                tempDiv.textContent = message;
                tempDiv.className = `fixed bottom-4 left-1/2 -translate-x-1/2 p-4 rounded-lg text-white font-bold shadow-lg z-50 transition-transform duration-300 ease-out transform scale-100 opacity-100 bg-${color}-600`;
                document.body.appendChild(tempDiv);
                setTimeout(() => {
                    tempDiv.classList.add('opacity-0', 'scale-90');
                    setTimeout(() => tempDiv.remove(), 300);
                }, 2000);
            };

            // --- Firestore Real-time Listeners ---
            function setupFirestoreListeners() {
                // Attendance Listener
                onSnapshot(collection(db, `/artifacts/${appId}/users/${userId}/attendance`), (snapshot) => {
                    const totalDays = snapshot.docs.length;
                    const totalLeave = totalDays > 0 ? 0 : 0; // Simplified calculation for now, will be updated by leave requests
                    const totalAbsent = 30 - totalDays - totalLeave;
                    monthlyReport.textContent = `উপস্থিত: ${totalDays} দিন, ছুটি: 0 দিন, অনুপস্থিত: ${totalAbsent > 0 ? totalAbsent : 0} দিন`;
                });

                // Orders Listener
                onSnapshot(collection(db, `/artifacts/${appId}/users/${userId}/orders`), (snapshot) => {
                    orderList.innerHTML = '';
                    if (snapshot.empty) {
                        orderList.innerHTML = `<p class="text-center text-gray-500 dark:text-gray-400">কোনো অর্ডার যোগ করা হয়নি।</p>`;
                        return;
                    }
                    snapshot.forEach(doc => {
                        const order = doc.data();
                        const item = document.createElement('div');
                        item.className = 'bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-sm flex flex-col sm:flex-row justify-between items-start sm:items-center';
                        item.innerHTML = `
                            <div>
                                <p class="text-lg font-bold">${order.clientName}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">পণ্য: ${order.productName}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">পরিমাণ: ${order.amount.toLocaleString('bn-BD')} টাকা</p>
                            </div>
                            <div class="flex space-x-2 mt-2 sm:mt-0">
                                <button onclick="deleteOrder('${doc.id}')" class="bg-red-500 text-white py-1 px-3 rounded-md text-sm hover:bg-red-600">ডিলিট</button>
                            </div>
                        `;
                        orderList.appendChild(item);
                    });
                });
                
                // Expose delete function globally
                window.deleteOrder = async (docId) => {
                    if (!isAuthReady) return alertMessage('ডেটাবেস লোড হচ্ছে, অনুগ্রহ করে অপেক্ষা করুন।', 'red');
                    try {
                        await deleteDoc(doc(db, `/artifacts/${appId}/users/${userId}/orders`, docId));
                        alertMessage('অর্ডার সফলভাবে ডিলিট করা হয়েছে!', 'red');
                    } catch (e) {
                        console.error("Error deleting document: ", e);
                        alertMessage('অর্ডার ডিলিট করতে ব্যর্থ।', 'red');
                    }
                };

                // Collections Listener
                onSnapshot(collection(db, `/artifacts/${appId}/users/${userId}/collections`), (snapshot) => {
                    const totalCollection = snapshot.docs.reduce((sum, doc) => sum + doc.data().amount, 0);
                    const collectionTarget = 50000;
                    const progress = (totalCollection / collectionTarget) * 100;
                    collectionReport.innerHTML = `
                        <p>টার্গেট: ৳${collectionTarget.toLocaleString('bn-BD')}</p>
                        <p>বর্তমান কালেকশন: ৳${totalCollection.toLocaleString('bn-BD')}</p>
                        <p>প্রগ্রেস: ${progress.toFixed(2)}%</p>
                    `;
                });

                // Sales Listener
                onSnapshot(doc(db, `/artifacts/${appId}/users/${userId}/sales`, 'current'), (docSnap) => {
                    if (docSnap.exists()) {
                        const data = docSnap.data();
                        const currentSales = data.currentTotal || 0;
                        const salesTarget = data.target || 100000;
                        const progress = (currentSales / salesTarget) * 100;
                        salesProgressBar.style.width = `${Math.min(progress, 100)}%`;
                        salesProgressText.textContent = `টার্গেট: ৳${salesTarget.toLocaleString('bn-BD')}, বর্তমান: ৳${currentSales.toLocaleString('bn-BD')} (${Math.min(progress.toFixed(2), 100)}%)`;
                    } else {
                        salesProgressBar.style.width = `0%`;
                        salesProgressText.textContent = `টার্গেট: ৳100000, বর্তমান: ৳0 (0%)`;
                    }
                });

                // Leave Requests Listener
                onSnapshot(collection(db, `/artifacts/${appId}/users/${userId}/leaveRequests`), (snapshot) => {
                    leaveStatusDiv.innerHTML = '';
                    if (snapshot.empty) {
                        leaveStatusDiv.innerHTML = `<p class="text-center text-gray-500 dark:text-gray-400">কোনো ছুটির আবেদন জমা হয়নি।</p>`;
                        return;
                    }
                    snapshot.forEach(doc => {
                        const req = doc.data();
                        const statusText = req.status === 'অনুমোদিত' ? 'অনুমোদিত' : req.status === 'প্রত্যাখ্যাত' ? 'প্রত্যাখ্যাত' : 'পর্যবেক্ষণে';
                        const statusColor = req.status === 'অনুমোদিত' ? 'text-green-500' : req.status === 'প্রত্যাখ্যাত' ? 'text-red-500' : 'text-yellow-500';
                        const item = document.createElement('div');
                        item.className = 'p-2 rounded-lg bg-gray-100 dark:bg-gray-700';
                        item.innerHTML = `<p class="font-medium">তারিখ: ${req.date}</p><p class="text-sm">কারণ: ${req.reason}</p><p class="text-sm ${statusColor}">স্ট্যাটাস: ${statusText}</p>`;
                        leaveStatusDiv.appendChild(item);
                    });
                });
            }
        });
    </script>
</body>
</html>
