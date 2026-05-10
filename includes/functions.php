<?php
// includes/functions.php

session_start();

/**
 * Échappe le HTML pour prévenir les failles XSS
 */
function h($string) {
    if ($string === null) {
        return '';
    }
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Crée un slug à partir d'une chaîne
 */
function slugify($text) {
    // Remplacer les caractères non alphanumériques par des tirets
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Translittération
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    // Supprimer les caractères indésirables
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '-');
    // Supprimer les tirets en double
    $text = preg_replace('~-+~', '-', $text);
    // Minuscule
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 * Vérifie si l'utilisateur est connecté
 */
function is_logged_in() {
    return isset($_SESSION['admin_id']);
}

/**
 * Récupère l'URL de base dynamiquement
 */
function get_base_url() {
    $script_dir = dirname($_SERVER['SCRIPT_NAME']);
    $script_dir = str_replace('\\', '/', $script_dir);
    if (preg_match('#/admin$#', $script_dir)) {
        $script_dir = dirname($script_dir);
    }
    if ($script_dir === '/' || $script_dir === '\\') {
        $script_dir = '';
    }
    return rtrim($script_dir, '/');
}

/**
 * Redirige vers la page de login si non connecté
 */
function require_login() {
    if (!is_logged_in()) {
        header('Location: ' . get_base_url() . '/admin/login.php');
        exit;
    }
}
