<?php
try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/portfolio.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Drop and recreate profile table to fix structure
    $pdo->exec("DROP TABLE IF EXISTS profile");
    $pdo->exec("CREATE TABLE profile (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        title TEXT NOT NULL,
        bio TEXT NOT NULL,
        image_url TEXT,
        email TEXT,
        phone TEXT,
        location TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create skills table
    $pdo->exec("CREATE TABLE IF NOT EXISTS skills (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        percentage INTEGER NOT NULL,
        category TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create experience table
    $pdo->exec("CREATE TABLE IF NOT EXISTS experience (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        position TEXT NOT NULL,
        company TEXT NOT NULL,
        period TEXT NOT NULL,
        description TEXT NOT NULL,
        start_date DATE,
        end_date DATE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create education table
    $pdo->exec("CREATE TABLE IF NOT EXISTS education (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        degree TEXT NOT NULL,
        institution TEXT NOT NULL,
        period TEXT NOT NULL,
        description TEXT NOT NULL,
        start_date DATE,
        end_date DATE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create articles table
    $pdo->exec("CREATE TABLE IF NOT EXISTS articles (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        content TEXT NOT NULL,
        excerpt TEXT,
        category TEXT NOT NULL,
        image_url TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create messages table
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        subject TEXT NOT NULL,
        message TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        read_at DATETIME
    )");

    // Create users table for admin
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create activities table
    $pdo->exec("CREATE TABLE IF NOT EXISTS activities (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        icon TEXT,
        link TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create portfolio table
    $pdo->exec("CREATE TABLE IF NOT EXISTS portfolio (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        image_url TEXT,
        category TEXT NOT NULL,
        project_url TEXT,
        github_url TEXT,
        technologies TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Insert sample profile data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM profile");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO profile (name, title, bio, image_url, email, phone, location) VALUES 
            ('Indra Sugara', 'An AI Enthusiast (And a History Geek)', 
            'Seorang developer passionate yang berfokus pada inovasi digital dan solusi teknologi modern, saat ini Berfokus dalam pembelajaran web full-stack, AI, dan software developing.', 
            'img/profile.png', 'sughara78@gmail.com', '+62 822-5930-6737', 'Karyamusa, Riau, Indonesia')");
    } else {
        // Update existing profile
        $pdo->exec("UPDATE profile SET 
            name = 'Indra Sugara', 
            title = 'AI Enthusiast', 
            bio = 'Seorang developer passionate yang berfokus pada inovasi digital dan solusi teknologi modern, saat ini Berfokus dalam pembelajaran web full-stack, AI, dan software developing.', 
            email = 'sughara78@gmail.com', 
            phone = '+62 822-5930-6737', 
            location = 'Karyamusa, Riau, Indonesia' 
            WHERE id = 1");
    }

    // Insert sample skills data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM skills");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO skills (name, percentage, category) VALUES 
            ('HTML/CSS', 95, 'Frontend'),
            ('JavaScript', 90, 'Frontend'),
            ('React.js', 85, 'Frontend'),
            ('Vue.js', 80, 'Frontend'),
            ('PHP', 88, 'Backend'),
            ('Node.js', 82, 'Backend'),
            ('Python', 85, 'Backend'),
            ('MySQL', 87, 'Database'),
            ('PostgreSQL', 83, 'Database'),
            ('Git/GitHub', 92, 'Tools'),
            ('Docker', 78, 'Tools'),
            ('AWS', 75, 'Cloud')");
    }

    // Insert sample experience data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM experience");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO experience (position, company, period, description, start_date, end_date) VALUES 
            ('Senior Full Stack Developer', 'Tech Innovation Corp', '2022 - Sekarang', 
            'Memimpin tim pengembangan aplikasi web dan mobile. Bertanggung jawab dalam arsitektur sistem, code review, dan mentoring junior developer.', 
            '2022-01-01', NULL),
            ('Full Stack Developer', 'Digital Solutions Ltd', '2020 - 2022', 
            'Mengembangkan aplikasi e-commerce dan sistem manajemen inventory. Menggunakan teknologi React, Node.js, dan PostgreSQL.', 
            '2020-03-01', '2022-12-31'),
            ('Frontend Developer', 'Creative Agency', '2019 - 2020', 
            'Fokus pada pengembangan interface user yang responsive dan interaktif. Bekerja dengan designer untuk implementasi UI/UX.', 
            '2019-06-01', '2020-02-28')");
    }

    // Insert sample education data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM education");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO education (degree, institution, period, description, start_date, end_date) VALUES 
            ('S1 Teknik Informatika', 'Universitas Maritim Raja Ali Haji', '2023 - Sekarang', 
            'Jurusan Teknik Informatika dengan fokus pada Software Engineering dan Database Systems. IPK: 3.5/4.0', 
            '2023-08-01', '2027-07-31'),
            ('SMA IPS', 'SMA Negeri 1 Teluk Belengkong', '2020 - 2023', 
            'Sekolah Menengah Atas jurusan IPS dengan prestasi akademik yang baik.', 
            '2020-07-01', '2023-06-30')");
    }

    // Insert sample articles data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM articles");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO articles (title, content, excerpt, category, image_url) VALUES 
            ('Panduan Lengkap React.js untuk Pemula', 
            '<h2>Pengenalan React.js</h2><p>React.js adalah library JavaScript yang dikembangkan oleh Facebook untuk membangun user interface yang interaktif...</p><h3>Komponen dalam React</h3><p>Komponen adalah building block utama dalam React...</p>', 
            'Pelajari dasar-dasar React.js mulai dari konsep komponen hingga state management dengan panduan lengkap ini.', 
            'Web Development', 'img/work1.jpg'),
            ('Tips Optimasi Performance Website', 
            '<h2>Mengapa Performance Penting?</h2><p>Performance website yang baik tidak hanya meningkatkan user experience...</p><h3>Teknik Optimasi</h3><p>Beberapa teknik yang bisa diterapkan...</p>', 
            'Teknik-teknik praktis untuk meningkatkan kecepatan loading website dan memberikan pengalaman user yang optimal.', 
            'Performance', 'img/work2.jpg'),
            ('Membangun API dengan Node.js dan Express', 
            '<h2>Setup Project</h2><p>Langkah pertama adalah membuat project Node.js baru...</p><h3>Routing dan Middleware</h3><p>Express menyediakan sistem routing yang powerful...</p>', 
            'Tutorial step-by-step membangun RESTful API menggunakan Node.js, Express, dan MongoDB.', 
            'Backend', 'img/work3.jpg')");
    }

    // Insert admin user (username: admin, password: admin123)
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute(['admin', $hashedPassword]);
    }

    // Insert sample activities
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM activities");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO activities (title, description, icon, link) VALUES 
            ('Konsultasi Web Development', 'Layanan konsultasi untuk pengembangan website dan aplikasi web modern', 'bx-code-alt', '#contact'),
            ('Mobile App Development', 'Pengembangan aplikasi mobile Android dan iOS dengan teknologi terkini', 'bx-mobile-alt', '#contact'),
            ('System Integration', 'Integrasi sistem dan API untuk meningkatkan efisiensi bisnis', 'bx-link-alt', '#contact'),
            ('Technical Training', 'Pelatihan teknis programming dan development untuk tim atau individu', 'bx-book-reader', '#contact')");
    }

    // Insert sample portfolio data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM portfolio");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO portfolio (title, description, image_url, category, project_url, github_url, technologies) VALUES 
            ('E-Commerce Platform', 'Platform e-commerce modern dengan fitur lengkap dan responsive design', 'img/work1.jpg', 'Web Development', '#', '#', 'React.js, Node.js, MongoDB'),
            ('Mobile Banking App', 'Aplikasi mobile banking dengan security tinggi dan UX yang intuitif', 'img/work2.jpg', 'Mobile App', '#', '#', 'React Native, Firebase, Node.js'),
            ('Corporate Website', 'Website corporate dengan CMS custom dan SEO optimization', 'img/work3.jpg', 'UI/UX Design', '#', '#', 'PHP, MySQL, jQuery, Bootstrap'),
            ('Task Management System', 'Sistem manajemen tugas dengan real-time collaboration', 'img/work4.jpg', 'Web Development', '#', '#', 'Vue.js, Laravel, PostgreSQL'),
            ('Inventory Management', 'Sistem manajemen inventori untuk retail dan warehouse', 'img/work5.jpg', 'System Integration', '#', '#', 'Python, Django, REST API')");
    }

    // Database initialized successfully
} catch(PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
}
?>
