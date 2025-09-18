export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./storage/framework/views/*.php", // Laravel compiled views
  ],
  safelist: [
    // Collapse / Accordion
    'collapse',
    'collapsing',
    'show',
    'collapsed',

    // Sidebar & nav
    'active',
    'nav-link',
    'nav-item',
    'navbar-nav',
    'menu-link',
    'menu-dropdown',
    'menu-title',
    'menu-arrow',
    'sidebar',
    'sidebar-user',
    'sidebar-background',

    // Dropdown
    'dropdown',
    'dropdown-menu',
    'dropdown-item',
    'dropdown-divider',

    // Bootstrap badges
    'badge',
    'badge-pill',
    'bg-danger',
    'bg-success',
    'bg-success-subtle',
    'text-success',
    'text-danger',

    // Regex para cubrir variantes dinámicas
    { pattern: /^bg-(primary|secondary|success|danger|warning|info|light|dark)$/ },
    { pattern: /^text-(primary|secondary|success|danger|warning|info|light|dark)$/ },
    { pattern: /^nav-.*/ },
    { pattern: /^dropdown-.*/ },
    { pattern: /^menu-.*/ },
  ],
  theme: {
    extend: {},
  },
  corePlugins: {
    preflight: false, // evita conflictos con Bootstrap
  },
  plugins: [],
}

module.exports = {
  darkMode: 'class', // ✅ importante
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
