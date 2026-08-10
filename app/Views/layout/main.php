<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin - PWM Sulbar' ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js (Dropdown/Toggle Sidebar) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        pwm: {
                            sidebar: '#0c325c',
                            sidebarHover: '#082545',
                            emerald: '#057a62',
                            red: '#d93838'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-100 font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">
        <!-- Include Sidebar -->
        <?= $this->include('layout/sidebar') ?>

        <!-- Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Include Header -->
            <?= $this->include('layout/header') ?>

            <!-- Main Content Area -->
            <main class="flex-1 p-6 md:p-8">
                <?= $this->renderSection('content') ?>
            </main>

            <!-- Include Footer -->
            <?= $this->include('layout/footer') ?>
        </div>
    </div>

</body>

</html>