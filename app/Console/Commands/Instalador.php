<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Rol;
use App\Models\Usuario;


class Instalador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando ejecuta el instalador inicial del proyecto';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(!$this->verificar()){
            $rol     = $this->crearRolSuperAdmin();
            $usuario = $this->crearUsuarioSuperAdmin();
            $usuario->roles()->attach($rol);
            $this->line('El rol y el usuario administrador se crearon correctamente');
        }else{
            $this->error('No se puede ejecutar el instalador, porque ya hay un rol creado');
        }
    }

    private function verificar(){
        return Rol::find(1);
        //$rol = Rol::find(1);
        //return false;
        //return $rol->isEmpty();

    }

    private function crearRolSuperAdmin(){
        $rol = "Super administrador";
        return Rol::create([
            'nombre' => $rol,
            'slug' => Str::slug($rol, '_')
            ]);

    }

    private function crearUsuarioSuperAdmin(){
        return Usuario::create([
            'nombre' => 'blog_admin',
            'email' => 'bolg@gmail.com',
            'password'=>  Hash::make('pass1234') ,
            'estado'  => 1
        ]);

    }
}
