<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // ====================
        // 1. CREAR PERMISOS
        // ====================
        
        // Permisos para Productos
        Permission::create(['name' => 'ver productos']);
        Permission::create(['name' => 'crear productos']);
        Permission::create(['name' => 'editar productos']);
        Permission::create(['name' => 'eliminar productos']);
        
        // Permisos para Categorías
        Permission::create(['name' => 'ver categorias']);
        Permission::create(['name' => 'crear categorias']);
        Permission::create(['name' => 'editar categorias']);
        Permission::create(['name' => 'eliminar categorias']);

        // ====================
        // 2. CREAR 2 ROLES
        // ====================
        
        // ROL 1: JEFE (TODO EL PODER)
        $jefe = Role::create(['name' => 'jefe']);
        $jefe->givePermissionTo(Permission::all());
        
        // ROL 2: USUARIO (SOLO VER)
        $usuario = Role::create(['name' => 'usuario']);
        $usuario->givePermissionTo(['ver productos', 'ver categorias']);

        // ====================
        // 3. ASIGNAR ROLES
        // ====================
        
        // CAMBIA ESTE EMAIL POR TU EMAIL REAL
        // Ejemplo: 'sebastian@gmail.com' o 'admin@tienda.com'
        $emailJefe = 'sebas635parra@gmail.com'; // ← ¡CAMBIAR POR TU EMAIL!
        
        $tuUsuario = User::where('email', $emailJefe)->first();
        
        if ($tuUsuario) {
            $tuUsuario->assignRole('jefe');
            echo "✅ Usuario {$tuUsuario->email} ahora es JEFE\n";
        } else {
            echo "⚠️  No se encontró usuario con email: {$emailJefe}\n";
            echo "📝 Asigna manualmente el rol 'jefe' desde tu base de datos\n";
            echo "📝 O crea un usuario con ese email primero\n";
        }
        
        // Todos los demás usuarios serán 'usuario'
        $otrosUsuarios = User::where('email', '!=', $emailJefe)->get();
        foreach ($otrosUsuarios as $user) {
            $user->assignRole('usuario');
        }
        
        echo "✅ Roles creados: 'jefe' y 'usuario'\n";
        echo "✅ Permisos asignados correctamente\n";
    }
}