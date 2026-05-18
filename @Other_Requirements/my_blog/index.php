<?php
$title = "Palaris Blog";
$author = "He Who Wished for Snowflakes";
$start = "The name is Meluin Palaris and I live in a place called the Philippines.";
$mid = "Living in my country made me appreciate cold environments even more. That is why Antarctica became my favorite place — a peaceful world filled with snow, ice, and penguins.";
$end = "Maybe one day we can experience eternal cold like this, becauce sometimes the coldest places create the warmest memories but i digress, anyway that's about it ♫ ";
$img = "img1.png";
$img2 = "img2.png";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        cursive: ['"Dancing Script"', 'cursive'],
                    }
                }
            }
        }
    </script>

    <title><?= $title ?></title>
</head>

<body class="bg-black text-white overflow-x-hidden font-cursive">

    <header class="fixed top-0 left-0 w-full z-50 bg-black/40 backdrop-blur-md border-b border-white/10">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-wide">
                Palaris Blog
            </h1>

            <nav class="space-x-6 text-sm uppercase tracking-widest">
                <a href="#" class="hover:text-gray-300 transition">Home</a>
                <a href="#" class="hover:text-gray-300 transition">About</a>
                <a href="#" class="hover:text-gray-300 transition">Gallery</a>
            </nav>
        </div>
    </header>

    <section class="relative min-h-screen flex items-center justify-center">

        <img src="<?= $img ?>" alt="Background"
            class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-black/70"></div>

        <div class="relative z-10 max-w-4xl text-center px-6">

            <h1 class="text-6xl md:text-7xl font-cursive font-bold mb-8 drop-shadow-lg">
                <?= $author ?>
            </h1>

            <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-3xl p-8 shadow-2xl">

                <p class="text-xl md:text-2xl leading-relaxed mb-6 text-gray-200">
                    <?= $start ?>
                </p>

                <p class="text-xl md:text-2xl leading-relaxed text-gray-200">
                    <?= $mid ?>
                </p>

            </div>

        </div>
    </section>

    <section class="relative py-24 px-6">

        <img src="<?= $img2 ?>" alt="Penguins"
            class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-black/75"></div>

        <div class="relative z-10 max-w-5xl mx-auto text-center">

            <h2 class="text-5xl font-cursive mb-10">
                My Favorite Place
            </h2>

            <div class="grid md:grid-cols-2 gap-10 items-center">

                <div class="group overflow-hidden rounded-3xl shadow-2xl border border-white/20">
                    <img src="<?= $img2 ?>" alt="My Image"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/20 shadow-xl">
                    <p class="text-2xl leading-relaxed text-gray-200">
                        <?= $end ?>
                    </p>

                    <button
                        class="mt-8 px-8 py-3 rounded-full bg-white text-black font-semibold hover:bg-gray-300 transition duration-300">
                        Explore More
                    </button>
                </div>

            </div>

        </div>
    </section>

    <footer class="bg-black border-t border-white/10 py-6 text-center text-gray-400">
        <p>
            © <?= date('Y') ?> Palaris Blog — All Rights Reserved
        </p>
    </footer>

</body>

</html>