import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs-extra';
import path from 'path';

const folder = {
    src: "resources/",
    src_assets: "resources/",
    dist: "public/",
    dist_assets: "public/build/"
};

export default defineConfig({
    build: {
        manifest: true,
        outDir: 'public/build/',
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                assetFileNames: (asset) => {
                    if (asset.name && asset.name.endsWith('.css')) {
                        return 'css/[name].min.css';
                    } else {
                        return 'assets/[name][extname]';
                    }
                },
                entryFileNames: 'js/[name].js',
            },
        },
    },
    plugins: [
        laravel({
            input: [
                // Solo necesitas estos archivos ahora
                'resources/scss/app.scss',  // Tailwind + estilos custom
                'resources/scss/icons.scss', // Si usas iconos custom
                'resources/js/app.js',
            ],
            refresh: [
                'resources/views/**',
            ],
        }),
        {
            name: 'copy-specific-packages',
            async writeBundle() {
                try {
                    // Copia assets necesarios
                    await Promise.all([
                        fs.copy(folder.src_assets + 'fonts', folder.dist_assets + 'fonts'),
                        fs.copy(folder.src_assets + 'images', folder.dist_assets + 'images'),
                        fs.copy(folder.src_assets + 'js', folder.dist_assets + 'js'),
                        fs.copy(folder.src_assets + 'lang', folder.dist_assets + 'lang'),
                        fs.copy(folder.src_assets + 'json', folder.dist_assets + 'json'),
                    ]);
                } catch (error) {
                    console.error('Error copying assets:', error);
                }

                // Copia paquetes específicos si es necesario
                const outputPath = path.resolve(__dirname, folder.dist_assets);
                const configPath = path.resolve(__dirname, 'package-copy-config.json');

                try {
                    const configContent = await fs.readFile(configPath, 'utf-8');
                    const { packagesToCopy } = JSON.parse(configContent);

                    for (const packageName of packagesToCopy) {
                        const destPackagePath = path.join(outputPath, 'libs', packageName);
                        const sourcePath = fs.existsSync(path.join(__dirname, 'node_modules', packageName + "/dist"))
                            ? path.join(__dirname, 'node_modules', packageName + "/dist")
                            : path.join(__dirname, 'node_modules', packageName);

                        try {
                            await fs.access(sourcePath, fs.constants.F_OK);
                            await fs.copy(sourcePath, destPackagePath);
                        } catch (error) {
                            console.error(`Package ${packageName} does not exist.`);
                        }
                    }
                } catch (error) {
                    // No hay problema si no existe el config file
                    if (error.code !== 'ENOENT') {
                        console.error('Error copying packages:', error);
                    }
                }
            },
        },
    ],
});