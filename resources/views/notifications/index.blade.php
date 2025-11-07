@extends('layouts.master')
@section('title', 'Notificaciones')

@section('content')
<div class="p-6" x-data="notificationsPage()">
    
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-3">
                <i class="ri-notification-3-line text-green-600"></i>
                Notificaciones
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Tienes <span x-text="contadorNoLeidas"></span> notificaciones sin leer
            </p>
        </div>
        
        <div class="flex gap-3">
            <button @click="markAllAsRead()" 
                    x-show="contadorNoLeidas > 0"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                <i class="ri-check-double-line"></i>
                Marcar todas como leídas
            </button>
            
            <button @click="clearRead()"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition flex items-center gap-2">
                <i class="ri-delete-bin-line"></i>
                Limpiar leídas
            </button>
        </div>
    </div>

    {{-- Mensajes de éxito/error --}}
    <div x-show="mensaje.show" 
         x-transition
         @click="mensaje.show = false"
         :class="mensaje.tipo === 'success' ? 'bg-green-50 border-green-500 text-green-800 dark:bg-green-900/20 dark:text-green-300' : 'bg-red-50 border-red-500 text-red-800 dark:bg-red-900/20 dark:text-red-300'"
         class="mb-6 border-l-4 p-4 rounded-lg cursor-pointer">
        <div class="flex items-center gap-3">
            <i :class="mensaje.tipo === 'success' ? 'ri-check-circle-line' : 'ri-error-warning-line'" class="text-xl"></i>
            <span x-text="mensaje.texto"></span>
            <i class="ri-close-line ml-auto"></i>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="mb-6 flex gap-3">
        <button @click="filtro = 'todas'" 
                :class="filtro === 'todas' ? 'bg-green-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700'"
                class="px-4 py-2 rounded-lg hover:bg-green-700 hover:text-white transition font-medium">
            Todas
        </button>
        <button @click="filtro = 'sin_leer'" 
                :class="filtro === 'sin_leer' ? 'bg-green-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700'"
                class="px-4 py-2 rounded-lg hover:bg-green-700 hover:text-white transition font-medium">
            Sin leer
        </button>
        <button @click="filtro = 'actividad'" 
                :class="filtro === 'actividad' ? 'bg-green-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700'"
                class="px-4 py-2 rounded-lg hover:bg-green-700 hover:text-white transition font-medium">
            Actividades
        </button>
        <button @click="filtro = 'informe'" 
                :class="filtro === 'informe' ? 'bg-green-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700'"
                class="px-4 py-2 rounded-lg hover:bg-green-700 hover:text-white transition font-medium">
            Informes
        </button>
    </div>

    {{-- Lista de notificaciones --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <template x-for="notification in notificacionesFiltradas" :key="notification.id">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition"
                 :class="!notification.read ? 'bg-blue-50 dark:bg-blue-900/10' : ''">
                <div class="flex items-start gap-4">
                    {{-- Icono --}}
                    <div :class="{
                        'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400': notification.color === 'blue',
                        'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400': notification.color === 'green',
                        'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400': notification.color === 'red',
                        'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400': notification.color === 'yellow'
                    }" class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0">
                        <i :class="notification.icon" class="text-xl"></i>
                    </div>
                    
                    {{-- Contenido --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4 mb-1">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100" x-text="notification.title"></h3>
                            <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap" x-text="timeAgo(notification.created_at)"></span>
                        </div>
                        
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3" x-text="notification.message"></p>
                        
                        <div class="flex items-center gap-3">
                            <a x-show="notification.link" 
                               :href="notification.link"
                               class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                Ver detalles →
                            </a>
                            
                            <button x-show="!notification.read"
                                    @click="markAsRead(notification.id)"
                                    class="text-sm text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                                Marcar como leída
                            </button>
                            
                            <button @click="confirmDelete(notification.id)"
                                    class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 ml-auto">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>
                    </div>
                    
                    {{-- Indicador no leída --}}
                    <div x-show="!notification.read" class="w-3 h-3 bg-blue-500 rounded-full flex-shrink-0 mt-2"></div>
                </div>
            </div>
        </template>

        {{-- Sin notificaciones --}}
        <div x-show="notificacionesFiltradas.length === 0" class="p-12 text-center text-gray-500 dark:text-gray-400">
            <i class="ri-notification-off-line text-6xl mb-4 opacity-50"></i>
            <p class="text-lg font-medium mb-1">No hay notificaciones</p>
            <p class="text-sm" x-text="mensajeSinNotificaciones"></p>
        </div>
    </div>

    {{-- Modal de confirmación para eliminar --}}
    <div x-show="showDeleteModal" 
         x-cloak
         @click.away="showDeleteModal = false"
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div @click.stop 
             x-transition
             class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ri-delete-bin-line text-3xl text-red-600 dark:text-red-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">¿Eliminar notificación?</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">
                    Esta acción no se puede deshacer.
                </p>
            </div>
            
            <div class="flex gap-3">
                <button @click="showDeleteModal = false"
                        class="flex-1 px-4 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                    Cancelar
                </button>
                <button @click="deleteNotification()"
                        class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition flex items-center justify-center gap-2">
                    <i class="ri-delete-bin-line"></i>
                    Eliminar
                </button>
            </div>
        </div>
    </div>

</div>

<script>
function notificationsPage() {
    return {
        filtro: 'todas',
        notificaciones: @json($notifications->items()),
        showDeleteModal: false,
        deleteId: null,
        mensaje: {
            show: false,
            tipo: 'success',
            texto: ''
        },
        
        get notificacionesFiltradas() {
            if (this.filtro === 'todas') {
                return this.notificaciones;
            } else if (this.filtro === 'sin_leer') {
                return this.notificaciones.filter(n => !n.read);
            } else if (this.filtro === 'actividad') {
                return this.notificaciones.filter(n => n.type === 'actividad');
            } else if (this.filtro === 'informe') {
                return this.notificaciones.filter(n => n.type === 'informe');
            }
            return this.notificaciones;
        },
        
        get contadorNoLeidas() {
            return this.notificaciones.filter(n => !n.read).length;
        },
        
        get mensajeSinNotificaciones() {
            if (this.filtro === 'sin_leer') return 'Todas tus notificaciones están leídas';
            if (this.filtro === 'actividad') return 'No tienes notificaciones de actividades';
            if (this.filtro === 'informe') return 'No tienes notificaciones de informes';
            return 'Cuando recibas notificaciones aparecerán aquí';
        },
        
        mostrarMensaje(texto, tipo = 'success') {
            this.mensaje = { show: true, tipo, texto };
            setTimeout(() => { this.mensaje.show = false; }, 3000);
        },
        
        async markAsRead(id) {
            try {
                const response = await fetch(`/notificaciones/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    const notification = this.notificaciones.find(n => n.id === id);
                    if (notification) {
                        notification.read = true;
                        this.mostrarMensaje('Notificación marcada como leída');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                this.mostrarMensaje('Error al marcar como leída', 'error');
            }
        },
        
        async markAllAsRead() {
            try {
                const response = await fetch('/notificaciones/read-all', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    this.notificaciones.forEach(n => n.read = true);
                    this.mostrarMensaje('Todas las notificaciones marcadas como leídas');
                }
            } catch (error) {
                console.error('Error:', error);
                this.mostrarMensaje('Error al marcar todas como leídas', 'error');
            }
        },
        
        async clearRead() {
            try {
                const response = await fetch('/notificaciones/clear-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    this.notificaciones = this.notificaciones.filter(n => !n.read);
                    this.mostrarMensaje('Notificaciones leídas eliminadas');
                }
            } catch (error) {
                console.error('Error:', error);
                this.mostrarMensaje('Error al limpiar notificaciones', 'error');
            }
        },
        
        confirmDelete(id) {
            this.deleteId = id;
            this.showDeleteModal = true;
        },
        
        async deleteNotification() {
            try {
                const response = await fetch(`/notificaciones/${this.deleteId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    this.notificaciones = this.notificaciones.filter(n => n.id !== this.deleteId);
                    this.showDeleteModal = false;
                    this.mostrarMensaje('Notificación eliminada');
                }
            } catch (error) {
                console.error('Error:', error);
                this.mostrarMensaje('Error al eliminar notificación', 'error');
            }
        },
        
        timeAgo(date) {
            const now = new Date();
            const then = new Date(date);
            const diff = Math.floor((now - then) / 1000);
            
            if (diff < 60) return 'Ahora';
            if (diff < 3600) return Math.floor(diff / 60) + ' min';
            if (diff < 86400) return Math.floor(diff / 3600) + ' h';
            if (diff < 2592000) return Math.floor(diff / 86400) + ' d';
            if (diff < 31536000) return Math.floor(diff / 2592000) + ' m';
            return Math.floor(diff / 31536000) + ' a';
        }
    }
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection