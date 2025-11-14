<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $creado_por_id
 * @property int|null $responsable_id
 * @property string $estado
 * @property int|null $aprobada_por
 * @property \Illuminate\Support\Carbon|null $fecha_aprobacion
 * @property int|null $rechazada_por
 * @property string|null $motivo_rechazo
 * @property \Illuminate\Support\Carbon|null $fecha_rechazo
 * @property array<array-key, mixed>|null $evidencias
 * @property string $titulo
 * @property string|null $autor
 * @property \Illuminate\Support\Carbon|null $fecha
 * @property string|null $tipo_area
 * @property string|null $resumen
 * @property string|null $contenido
 * @property string|null $presupuesto
 * @property string|null $tipo_presupuesto
 * @property string|null $numero
 * @property string|null $fase
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $aprobador
 * @property-read \App\Models\User|null $creador
 * @property-read \App\Models\User|null $rechazador
 * @property-read \App\Models\User|null $responsable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereAprobadaPor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereAutor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereContenido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereCreadoPorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereEvidencias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereFase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereFechaAprobacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereFechaRechazo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereMotivoRechazo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad wherePresupuesto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereRechazadaPor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereResponsableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereResumen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereTipoArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereTipoPresupuesto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actividad whereUpdatedAt($value)
 */
	class Actividad extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $id_superior
 * @property string|null $nombre
 * @property string|null $puesto
 * @property string|null $departamento
 * @property int|null $jerarquia
 * @property int|null $orden_visual
 * @property bool|null $esta_vacio
 * @property string $fecha_creacion
 * @property string $fecha_modificacion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Cargo> $subordinados
 * @property-read int|null $subordinados_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereDepartamento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereEstaVacio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereFechaCreacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereFechaModificacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereIdSuperior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereJerarquia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereOrdenVisual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo wherePuesto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cargo whereUpdatedAt($value)
 */
	class Cargo extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string|null $portada_imagen_path
 * @property string|null $plantilla_imagen_path
 * @property string|null $presidente_nombre
 * @property string|null $presidente_cargo
 * @property string|null $sindicato_nombre
 * @property string|null $sindicato_cargo
 * @property string|null $secretario_nombre
 * @property string|null $secretario_cargo
 * @property string|null $comuna_imagen_path
 * @property array<array-key, mixed>|null $regidores
 * @property string|null $municipio_nombre
 * @property string|null $municipio_descripcion
 * @property string|null $municipio_imagen_path
 * @property string|null $introduccion
 * @property string|null $introduccion_imagen_path
 * @property string|null $gobierno_introduccion
 * @property string|null $gobierno_imagen_path
 * @property \Illuminate\Support\Carbon $actividades_fecha_inicio
 * @property \Illuminate\Support\Carbon $actividades_fecha_fin
 * @property array<array-key, mixed>|null $dependencias_seleccionadas
 * @property string|null $pdf_path
 * @property int $descargas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $aprobador
 * @property-read \App\Models\User $creador
 * @property-read \App\Models\User|null $rechazador
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InformeSeccion> $secciones
 * @property-read int|null $secciones_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereActividadesFechaFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereActividadesFechaInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereComunaImagenPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereDependenciasSeleccionadas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereDescargas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereGobiernoImagenPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereGobiernoIntroduccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereIntroduccion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereIntroduccionImagenPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereMunicipioDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereMunicipioImagenPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereMunicipioNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe wherePdfPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe wherePlantillaImagenPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe wherePortadaImagenPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe wherePresidenteCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe wherePresidenteNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereRegidores($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereSecretarioCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereSecretarioNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereSindicatoCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereSindicatoNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Informe withoutTrashed()
 */
	class Informe extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $informe_id
 * @property string $titulo
 * @property string|null $contenido
 * @property int $nivel
 * @property int $orden
 * @property int|null $pagina
 * @property int $mostrar_indice
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $numero_seccion
 * @property-read \App\Models\Informe $informe
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereContenido($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereInformeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereMostrarIndice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereNivel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion wherePagina($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InformeSeccion whereUpdatedAt($value)
 */
	class InformeSeccion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $title
 * @property string $message
 * @property string|null $icon
 * @property string $color
 * @property string|null $link
 * @property bool $read
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $time_ago
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification ofType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification read()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification unread()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $nombre
 * @property string|null $cargo
 * @property string|null $foto
 * @property string|null $biografia
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente whereBiografia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente whereCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Presidente whereUpdatedAt($value)
 */
	class Presidente extends \Eloquent {}
}

namespace App\Models{
/**
 * @method bool hasRole(string $roleName)
 * @method \Illuminate\Database\Eloquent\Relations\HasMany notifications()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany unreadNotifications()
 * @property int $id
 * @property string $name
 * @property string|null $sexo
 * @property string $email
 * @property string|null $telefono
 * @property string $cargo
 * @property int|null $jefe_id
 * @property int $orden
 * @property string|null $area
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $last_login_at
 * @property string|null $last_login_ip
 * @property array<array-key, mixed>|null $login_history
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCargo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereJefeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLoginHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSexo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

