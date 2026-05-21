<?php
namespace App\Controllers;

use App\Models\Categoria_model;
use App\Models\Direccion_model;
use App\Models\Localidad_model;
use App\Models\Marca_model;
use App\Models\Perfil_model;
use App\Models\Usuarios_model;
use CodeIgniter\Controller;

class Usuario_controller extends Controller{
    public function index(){
        helper(['form', 'url']);
    }

    public function listaUsuarios(){
        $usuarioModel = new Usuarios_model();
        $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->getUsuariosPaginados(7);
        $data['pager'] = $usuarioModel->pager;

        // $data['usuarios'] = $usuarioModel->getUsuarioAll();

        $dato['titulo'] = 'Dashboard | Lista de Usuarios';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaUsuarios', $data);
        echo view('plantillas/footer');
    }

    public function buscadorUsuarios(){
        $session = session();
        $queryUsuario = $this->request->getVar('usuarioQuery'); 
        $usuarioModel = new Usuarios_model();

        if($queryUsuario){ 
            $data['usuarios'] = $usuarioModel->buscarUsuariosActivosPaginados($queryUsuario, 7);
            $data['pager'] = $usuarioModel->pager;
        } else {
            $data['usuarios'] = [];
            $data['pager'] = null;
        }

        $session->setFlashdata('usuarioQueryValor', $queryUsuario);
        $dato['titulo'] = 'Dashboard | Lista de Usuarios';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaUsuarios', $data);
        echo view('plantillas/footer');
    }

    public function indexDesactivados(){
        $usuarioModel = new Usuarios_model();
        $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->getUsuariosDesactivadosPaginados(7);
        $data['pager'] = $usuarioModel->pager;

        $dato['titulo'] = 'Dashboard | Lista de Usuarios';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaUsuariosDesactivados', $data);
        echo view('plantillas/footer');
    }

    public function buscadorUsuariosDesactivados(){
        $session = session();
        $queryUsuarioDesactivado = $this->request->getVar('usuarioDesactivadoQuery'); 
        $usuarioModel = new Usuarios_model();

        if($queryUsuarioDesactivado){ 
            $data['usuarios'] = $usuarioModel->buscarUsuariosDesactivadosPaginados($queryUsuarioDesactivado, 7);
            $data['pager'] = $usuarioModel->pager;
        } else {
            $data['usuarios'] = [];
            $data['pager'] = null;
        }

        $session->setFlashdata('usuarioDesactivadoQueryValor', $queryUsuarioDesactivado);
        $dato['titulo'] = 'Dashboard | Lista de Usuarios';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaUsuariosDesactivados', $data);
        echo view('plantillas/footer');
    }

    public function indexParaActivar(){
        $usuarioModel = new Usuarios_model();
        $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->getUsuariosDesactivadosPaginados(7);
        $data['pager'] = $usuarioModel->pager;

        $dato['titulo'] = 'Dashboard | Lista de Usuarios';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaUsuariosParaActivar', $data);
        echo view('plantillas/footer');
    }

    public function buscadorUsuariosParaActivar(){
        $session = session();
        $queryUsuarioParaActivar = $this->request->getVar('usuarioParaActivarQuery'); 
        $usuarioModel = new Usuarios_model();

        if($queryUsuarioParaActivar){ 
            $data['usuarios'] = $usuarioModel->buscarUsuariosDesactivadosPaginados($queryUsuarioParaActivar, 7);
            $data['pager'] = $usuarioModel->pager;
        } else {
            $data['usuarios'] = [];
            $data['pager'] = null;
        }

        $session->setFlashdata('usuarioParaActivarQueryValor', $queryUsuarioParaActivar);
        $dato['titulo'] = 'Dashboard | Lista de Usuarios';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaUsuariosParaActivar', $data);
        echo view('plantillas/footer');
    }

    public function indexActualizarEliminar(){
        $usuarioModel = new Usuarios_model();

        $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->getUsuariosPaginados(7);
        $data['pager'] = $usuarioModel->pager;

        $dato['titulo'] = 'Dashboard | Lista de Usuarios';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaUsuariosActualizarEliminar', $data);
        echo view('plantillas/footer');
    }

    public function buscadorUsuariosAct(){
        $session = session();
        $queryUsuarioAct = $this->request->getVar('usuarioActQuery'); 
        $usuarioModel = new Usuarios_model();

        if($queryUsuarioAct){ 
            $data['usuarios'] = $usuarioModel->buscarUsuariosActivosPaginados($queryUsuarioAct, 7);
            $data['pager'] = $usuarioModel->pager;
        } else {
            $data['usuarios'] = [];
            $data['pager'] = null;
        }

        $session->setFlashdata('usuarioActQueryValor', $queryUsuarioAct);
        $dato['titulo'] = 'Dashboard | Lista de Usuarios';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/listaUsuariosActualizarEliminar', $data);
        echo view('plantillas/footer');
    }

    public function crearUsuario(){
        $perfilModel = new Perfil_model();
        $data['perfiles'] = $perfilModel->getPerfilActivos();
        $localidadModel = new Localidad_model();
        $data['localidades'] = $localidadModel->getLocalidadConProvincia();

        $dato['titulo'] = 'Dashboard | Agregar Usuario';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDeUsuarios', $data);
        echo view('plantillas/footer');
    }

    public function actualizarUsuario($id){
        $perfilModel = new Perfil_model();
        $data['perfiles'] = $perfilModel->getPerfilActivos();
        $usuarioModel = new Usuarios_model();
        $data['usuario'] = $usuarioModel->find($id);
        $direccionModel = new Direccion_model();
        $data['direccion'] = $direccionModel->where('id_usuario', $id)->first();
        $localidadModel = new Localidad_model();
        $data['localidades'] = $localidadModel->getLocalidadConProvincia();

        $dato['titulo'] = 'Dashboard | Editar Usuario';
        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarUsuarios', $data);
        echo view('plantillas/footer');
    }

    public function eliminarUsuario($id){
        $usuarioModel = new Usuarios_model();
        $data['usuario'] = $usuarioModel->find($id);

        $data = ['baja' => 'SI'];
        $usuarioModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'El Usuario fue dado de baja exitosamente');
        return redirect()->to('/mostrarListaUsuariosActualizarEliminar');
    }

    public function activarUsuario($id){
        $usuarioModel = new Usuarios_model();
        $data['usuario'] = $usuarioModel->find($id);

        $data = ['baja' => 'NO'];
        $usuarioModel->update($id, $data);

        session()->setFlashdata('msgExitoso', 'El Usuario fue habilitado exitosamente');
        return redirect()->to('/mostrarListaUsuariosParaActivar');
    }

    public function registrarse(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriaAll();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcaAll();
        $localidadModel = new Localidad_model();
        $dato['localidades'] = $localidadModel->getLocalidadConProvincia();

        $data['titulo'] = 'NetShop | Registro';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('back/usuario/registrarse', $dato);
        echo view('plantillas/footer', $dato);
    }

    public function formValidation(){
        $session = session();

        $nombre = $this->request->getVar('nombre');
        $apellido = $this->request->getVar('apellido');
        $usuario = $this->request->getVar('usuario');
        $email = $this->request->getVar('email');
        $contraseña = $this->request->getVar('contraseña');

        $barrio = $this->request->getVar('barrio');
        $calle = $this->request->getVar('calle');
        $numero = $this->request->getVar('numero');
        $localidad = $this->request->getVar('localidad');

        $input = $this->validate([
            'nombre' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]',
            'apellido' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]',
            'usuario' => 'required|trim|min_length[4]|max_length[20]|is_unique[usuario.usuario]',
            'email' => 'required|trim|valid_email|regex_match[/^[\w\.\-]+@[\w\-]+\.(com)$/]|is_unique[usuario.email]',
            'contraseña' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/]',
            'barrio' => 'permit_empty|trim|max_length[100]',
            'calle' => 'permit_empty|trim|max_length[100]',
            'numero' => 'permit_empty|trim|max_length[11]|is_natural',
            'localidad'=> 'required'
        ]);

        $formModel = new Usuarios_model();
        $direccionModel = new Direccion_model();

        if(!$input){
            $categoriaModel = new Categoria_model();
            $dato['categorias'] = $categoriaModel->getCategoriaAll();

            $session->setFlashdata('validationErrors', $this->validator->getErrors());
            $session->setFlashdata('nombreValor1', $nombre);
            $session->setFlashdata('apellidoValor1', $apellido);
            $session->setFlashdata('usuarioValor1', $usuario);
            $session->setFlashdata('emailValor1', $email);
            $session->setFlashdata('passwordValor1', $contraseña);

            $session->setFlashdata('barrioValor1', $barrio);
            $session->setFlashdata('calleValor1', $calle);
            $session->setFlashdata('numeroValor1', $numero);
            $session->setFlashdata('localidadValor1', $localidad);

            return redirect()->to('/registrarse');
        } else{
            $formModel->save([
                'nombre' => $this->request->getVar('nombre'),
                'apellido' => $this->request->getVar('apellido'),
                'usuario' => $this->request->getVar('usuario'),
                'email' => $this->request->getVar('email'),
                'pass' => password_hash($this->request->getVar('contraseña'), PASSWORD_DEFAULT)
            ]);

            // 2. Obtener id del usuario recién creado
            $idUsuario = $formModel->getInsertID();

            // 3. Si completó dirección, guardarla
            if ($this->request->getVar('barrio') || $this->request->getVar('calle') || $this->request->getVar('numero') || $this->request->getVar('localidad')) {
                $direccionModel->save([
                    'barrio'      => $this->request->getVar('barrio'),
                    'calle'       => $this->request->getVar('calle'),
                    'numero'      => $this->request->getVar('numero'),
                    'id_localidad'   => $this->request->getVar('localidad'),
                    'id_usuario'  => $idUsuario
                ]);
            }

            session()->setFlashdata('msgExitoso', 'Usuario registrado exitosamente');
            return redirect()->to('/registrarse');
        }
    }

    public function formValidationUsuario(){
        $session = session();

        $nombreUsuario = $this->request->getVar('nombre');
        $apellidoUsuario = $this->request->getVar('apellido');
        $usuarioUsers = $this->request->getVar('usuario');
        $emailUsuario = $this->request->getVar('email');
        $contraseñaUsuario = $this->request->getVar('contraseña');
        $perfilUsuario = $this->request->getVar('perfil');

        $barrioUsuario = $this->request->getVar('barrio');
        $calleUsuario = $this->request->getVar('calle');
        $numeroUsuario = $this->request->getVar('numero');
        $localidadUsuario = $this->request->getVar('localidad');

        $input = $this->validate([
            'nombre' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]',
            'apellido' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]',
            'usuario' => 'required|trim|min_length[4]|max_length[20]|is_unique[usuario.usuario]',
            'email' => 'required|trim|valid_email|regex_match[/^[\w\.\-]+@[\w\-]+\.(com)$/]|is_unique[usuario.email]',
            'contraseña' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/]',
            'perfil' => 'required',
            'barrio' => 'permit_empty|trim|max_length[100]',
            'calle' => 'permit_empty|trim|max_length[100]',
            'numero' => 'permit_empty|trim|max_length[11]|is_natural',
            'localidad' => 'required'
        ]);

        $formModel = new Usuarios_model();
        $direccionModel = new Direccion_model();

        if(!$input){
            $perfilModel = new Perfil_model();
            $data['perfiles'] = $perfilModel->findAll();
            $localidadModel = new Localidad_model();
            $data['localidades'] = $localidadModel->getLocalidadConProvincia();
            // $data['validation'] = $this->validator;

            $session->setFlashdata('usuarioNombreValor', $nombreUsuario);
            $session->setFlashdata('usuarioApellidoValor', $apellidoUsuario);
            $session->setFlashdata('usuarioUsersValor', $usuarioUsers);
            $session->setFlashdata('usuarioEmailValor', $emailUsuario);
            $session->setFlashdata('usuarioContraseñaValor', $contraseñaUsuario);
            $session->setFlashdata('usuarioPerfilValor', $perfilUsuario);

            $session->setFlashdata('usuarioBarrioValor', $barrioUsuario);
            $session->setFlashdata('usuarioCalleValor', $calleUsuario);
            $session->setFlashdata('usuarioNumeroValor', $numeroUsuario);
            $session->setFlashdata('usuarioLocalidadValor', $localidadUsuario);

            $dato['titulo'] = 'Dashboard | Agregar Usuario';
            echo view('plantillas/header', $dato);
            echo view('plantillas/nav');
            echo view('back/admin/altaDeUsuarios', $data, ['validation' => $this->validator]);
            // echo view('back/admin/altaDeUsuarios', $data);
            echo view('plantillas/footer');

        } else{
            $formModel->save([
                'nombre' => $this->request->getVar('nombre'),
                'apellido' => $this->request->getVar('apellido'),
                'usuario' => $this->request->getVar('usuario'),
                'email' => $this->request->getVar('email'),
                'pass' => password_hash($this->request->getVar('contraseña'), PASSWORD_DEFAULT),
                'id_perfil' => $this->request->getVar('perfil'),
            ]);

            // Obtener id del usuario recién creado
            $idUsuario = $formModel->getInsertID();

            // Guardar dirección vinculada
            if ($this->request->getVar('barrio') || $this->request->getVar('calle') || $this->request->getVar('numero') || $this->request->getVar('localidad')) {
                $direccionModel->save([
                    'barrio'       => $this->request->getVar('barrio'),
                    'calle'        => $this->request->getVar('calle'),
                    'numero'       => $this->request->getVar('numero'),
                    'id_localidad' => $this->request->getVar('localidad'),
                    'id_usuario'   => $idUsuario
                ]);
            }

            session()->setFlashdata('msgExitoso', 'Usuario registrado exitosamente');
            return redirect()->to('/altaDeUsuarios');
        }
    }

    public function formValidationUpdate(){
        $id = $this->request->getVar('id');

        $input = $this->validate([
            'id' => 'required|numeric',
            'nombre' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]',
            'apellido' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]',
            'usuario' => 'required|trim|min_length[4]|max_length[20]|is_unique[usuario.usuario,id_usuario,' . $id . ']',
            'email' => 'required|trim|valid_email|regex_match[/^[\w\.\-]+@[\w\-]+\.(com)$/]|is_unique[usuario.email,id_usuario,' . $id . ']',
            'contraseña' => 'trim|permit_empty|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/]',
            'perfil' => 'required',
            'barrio' => 'permit_empty|trim|max_length[100]',
            'calle' => 'permit_empty|trim|max_length[100]',
            'numero' => 'permit_empty|trim|max_length[11]|is_natural',
            'localidad' => 'required'
        ]);
        if(!$input){
            $usuarioModel = new Usuarios_model();
            $data['usuario'] = $usuarioModel->find($this->request->getVar('id'));
            $perfilModel = new Perfil_model();
            $data['perfiles'] = $perfilModel->findAll();
            $direccionModel = new Direccion_model();
            $data['direccion'] = $direccionModel->where('id_usuario', $id)->first();
            $localidadModel = new Localidad_model();
            $data['localidades'] = $localidadModel->getLocalidadConProvincia();
            $data['validation'] = $this->validator;

            $dato['titulo'] = 'Dashboard | Editar Usuario';
            echo view('plantillas/header', $dato);
            echo view('plantillas/nav');
            echo view('back/admin/actualizarUsuarios', $data);
            echo view('plantillas/footer');
        } else {
            $data = [
                'nombre'   => $this->request->getVar('nombre'),
                'apellido' => $this->request->getVar('apellido'),
                'usuario'  => $this->request->getVar('usuario'),
                'email'    => $this->request->getVar('email'),
                'id_perfil'    => $this->request->getVar('perfil'),
            ];

            $nuevaContraseña = $this->request->getVar('contraseña');
            if (!empty($nuevaContraseña)) {
                $data['pass'] = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
            }

            $usuarioModel = new Usuarios_model();
            $usuarioModel->update($id, $data);

            // Actualizar dirección
            $direccionModel = new Direccion_model();
            $direccionData = [
                'barrio'       => $this->request->getVar('barrio'),
                'calle'        => $this->request->getVar('calle'),
                'numero'       => $this->request->getVar('numero'),
                'id_localidad' => $this->request->getVar('localidad'),
                'id_usuario'   => $id
            ];

            // Si ya existe dirección, actualizar; si no, crear
            $direccionExistente = $direccionModel->where('id_usuario', $id)->first();
            if ($direccionExistente) {
                $direccionModel->update($direccionExistente['id_direccion'], $direccionData);
            } else {
                $direccionModel->save($direccionData);
            }

            // $id = $this->request->getVar('id');
            // $usuarioModel->update($id, $data);

            session()->setFlashdata('msgExitoso', 'Usuario actualizado exitosamente');
            return redirect()->to('/mostrarListaUsuariosActualizarEliminar');
        }
    }

    public function limpiarDatos() {
        session()->remove(['nombreValor1', 'apellidoValor1', 'usuarioValor1', 'emailValor1', 'passwordValor1']);
        return redirect()->to('/registrarse');
    }

    public function limpiarDatosUser() {
        session()->remove(['usuarioNombreValor', 'usuarioApellidoValor', 'usuarioUsersValor', 'usuarioEmailValor', 'usuarioContraseñaValor', 'usuarioPerfilValor']);
        return redirect()->to('/altaDeUsuarios');
    }

    public function limpiarDatosUserAct($id) {
        session()->setFlashdata('limpiarUsuarioValor', true);
        return redirect()->to('/actualizarUsuarios/' . $id);
    }
}