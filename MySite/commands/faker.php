<?php

require dirname(__DIR__).'/../vendor/autoload.php';
use Vincent\Connected\Connected;

$faker = Faker\Factory::create('fr-FR');

$cbd = (new Connected())->connectedToDataBase();

//$posts = [];
//$categories = [];
//
//for ($i = 1; $i < 50; $i++){
//    $req = $cbd->prepare("INSERT INTO post(name, slug, content, created_at) VALUES(?, ?, ?, ?)");
//    $req->execute(array($faker->sentence(), $faker->slug, $faker->paragraphs(rand(3, 15), true), $faker->date.' '. $faker->time));
//    $posts[] = $cbd->lastInsertId();
//}
//
//
//for ($i = 1; $i < 25; $i++){
//    $req = $cbd->prepare("INSERT INTO category(name, slug) VALUES(?, ?)");
//    $req->execute(array($faker->sentence(3), $faker->slug));
//    $categories[] = $cbd->lastInsertId();
//}
//
//foreach ($posts as $post) {
//    $randomCategories = $faker->randomElements($categories, rand(0, count($categories))); //array contenant des valeurs aléatoires issues de $categories
//    foreach ($randomCategories as $category) {
//        $req = $cbd->prepare("INSERT INTO post_category(post_id, category_id) VALUES(?, ?)");
//        $req->execute(array($post, $category));
//    }
//}
//$pass = password_hash('0000', PASSWORD_BCRYPT);
//$cbd->exec("INSERT INTO user SET username='admin', password='$pass'");
