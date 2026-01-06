<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ColaboradorController extends Controller
{
    /**
     * Mostrar la vista de colaboradores con estado en línea.
     */
    public function index()
    {
        // Definir colaboradores con sus emails
        $colaboradores = [
            [
                'name' => 'Mariana Lilibeth Antúnez García',
                'email' => 'mariana_lili25@hotmail.com',
                'role' => 'Usuarios & Diseño de Interfaces',
                'img' => 'storage/colaboradores/1mariana.png',
                'desc' => 'Encargada de la creación y configuración de usuarios dentro del SIGAT, definiendo la estructura de alta y administración básica de cuentas. Colabora en el diseño de interfaces, especialmente en las vistas Blade de actividades y usuarios, aportando mejoras visuales y apoyando en la identificación de errores de interfaz y flujo para mantener una experiencia de uso clara y consistente.',
                'skills' => ['Gestión de usuarios', 'Diseño de vistas', 'Detección de errores'],
            ],
            [
                'name' => 'José Ángel Alonso León',
                'email' => 'joseleon2021.jaa@gmail.com',
                'role' => 'Diseño & Análisis Funcional',
                'img' => 'storage/colaboradores/2dark.png',
                'desc' => 'Colaborador enfocado en el diseño visual y la experiencia de uso del SIGAT, proponiendo mejoras de interfaz y coherencia gráfica. Apoya en la detección y documentación de bugs, así como en el análisis funcional del sistema mediante casos de uso, diagramas de flujo y documentación técnica que respalda las decisiones de desarrollo.',
                'skills' => ['Diseño UI', 'Casos de uso', 'Diagramas de flujo', 'Soporte de bugs'],
            ],
            [
                'name' => 'Maico Zaet Pérez Valencia',
                'email' => 'zaet_maico@hotmail.com',
                'role' => 'Arquitecto de Plataforma',
                'img' => 'storage/colaboradores/3zaet.png',
                'desc' => 'Líder técnico responsable de la arquitectura, diseño y desarrollo integral del SIGAT. Especializado en ingeniería de bases de datos, desarrollo backend robusto con Laravel, implementación de lógica empresarial compleja, diseño frontend responsivo con Tailwind CSS, interactividad con Alpine.js, generación de reportes PDF con mPDF, resolución de problemas críticos y optimización de rendimiento. Visión arquitectónica del sistema municipal.',
                'skills' => ['Laravel', 'MySQL', 'PHP', 'Tailwind', 'Alpine.js', 'mPDF'],
            ],
            [
                'name' => 'Jorge Campos Albarado',
                'email' => 'chilindrino_hack@hotmail.com',
                'role' => 'Roles, Permisos y Perfiles',
                'img' => 'storage/colaboradores/4chili.png',
                'desc' => 'Responsable del diseño, configuración y mantenimiento del esquema de roles y permisos del SIGAT, garantizando que cada usuario tenga el nivel de acceso adecuado según su función dentro del ayuntamiento. Encargado de la gestión del perfil de usuario, incluyendo edición de datos, fotografía de avatar y parámetros de cuenta, asegurando una experiencia de uso coherente y segura en todo el sistema.',
                'skills' => ['Roles & Permisos', 'Perfiles de Usuario', 'Seguridad'],
            ],
        ];

        // Cargar usuarios y verificar si están en línea
        foreach ($colaboradores as &$colab) {
            $user = User::where('email', $colab['email'])->first();
            $colab['user'] = $user;
            $colab['online'] = $user ? isUserOnline($user->id) : false;
        }

        return view('colaboradores', compact('colaboradores'));
    }
}
