<?php
namespace App\Controllers;

use App\Models\Categoria_model;
use App\Models\Direccion_model;
use App\Models\Localidad_model;
use App\Models\Marca_model;
use App\Models\Perfil_model;
use App\Models\Provincia_model;
use App\Models\Usuarios_model;
use CodeIgniter\Controller;

class Usuario_controller extends Controller{
    public function index(){
        helper(['form', 'url']);
    }

     // LISTAR Y BUSCAR USUARIOS (ADMIN)
    public function listarUsuarios($estadoUsuarios){
        $usuarioModel = new Usuarios_model();

        switch($estadoUsuarios){
            case 'desactivados':
                $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->getUsuariosDesactivados();
                $vista = 'back/admin/listaUsuariosDesactivados';
                break;
            case 'actualizarEliminar':
                $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->getUsuarioAll();
                $vista = 'back/admin/listaUsuariosActualizarEliminar';
                break;
            default: // activos
                $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->getUsuariosActivos();
                $vista = 'back/admin/listaUsuarios';
                break;
        }

        $data['pager'] = $usuarioModel->pager;
        $dato['titulo'] = 'Dashboard | Lista de Usuarios';

        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view($vista, $data);
        echo view('plantillas/footer');
    }

    public function buscarUsuarios($estadoUsuarios){
        $session = session();
        $usuarioModel = new Usuarios_model();

        switch($estadoUsuarios){
            case 'desactivados':
                $query = $this->request->getVar('usuarioDesactivadoQuery');
                $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->buscarUsuariosDesactivados($query);
                $session->setFlashdata('usuarioDesactivadoQueryValor', $query);
                $vista = 'back/admin/listaUsuariosDesactivados';
                break;
            case 'actualizarEliminar':
                $query = $this->request->getVar('usuarioActQuery');
                $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->buscarUsuariosAll($query);
                $session->setFlashdata('usuarioActQueryValor', $query);
                $vista = 'back/admin/listaUsuariosActualizarEliminar';
                break;
            default: // activos
                $query = $this->request->getVar('usuarioQuery');
                $data['usuarios'] = $usuarioModel->orderBy('usuario.id_usuario', 'DESC')->buscarUsuariosActivos($query);
                $session->setFlashdata('usuarioQueryValor', $query);
                $vista = 'back/admin/listaUsuarios';
                break;
        }

        $data['pager'] = $usuarioModel->pager;
        $dato['titulo'] = 'Dashboard | Lista de Usuarios';

        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view($vista, $data);
        echo view('plantillas/footer');
    }

    // MOSTRAR FORMULARIOS (ADMIN)
    public function mostrarFormularioCrearUsuario(){
        $perfilModel = new Perfil_model();
        $data['perfiles'] = $perfilModel->getPerfilesActivos();
        $localidadModel = new Localidad_model();
        $dato['localidades'] = $localidadModel->getLocalidadesActivas();
        $provinciaModel = new Provincia_model();
        $dato['provincias'] = $provinciaModel->getProvinciasActivas();

        $data['validation'] = $this->validator;
        $dato['titulo'] = 'Dashboard | Agregar Usuario';

        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/altaDeUsuarios', $data);
        echo view('plantillas/footer');
    }

    public function mostrarFormularioActualizarUsuario($idUsuario){
        $perfilModel = new Perfil_model();
        $data['perfiles'] = $perfilModel->getPerfilesActivos();
        $usuarioModel = new Usuarios_model();
        $data['usuario'] = $usuarioModel->find($idUsuario);
        $direccionModel = new Direccion_model();
        $data['direccion'] = $direccionModel->where('id_usuario', $idUsuario)->first();
        $localidadModel = new Localidad_model();
        $dato['localidades'] = $localidadModel->getLocalidadesActivas();
        $provinciaModel = new Provincia_model();
        $dato['provincias'] = $provinciaModel->getProvinciasActivas();

        $data['validation'] = $this->validator;
        $dato['titulo'] = 'Dashboard | Editar Usuario';

        echo view('plantillas/header', $dato);
        echo view('plantillas/nav');
        echo view('back/admin/actualizarUsuarios', $data);
        echo view('plantillas/footer');
    }

    public function mostrarMensajeConfirmacionUsuario($idUsuario, $accion) {
        $usuarioModel = new Usuarios_model();
        $usuario = $usuarioModel->find($idUsuario);

        $dato['titulo'] = 'Dashboard | Confirmar acción';
        echo view('plantillas/header', $dato);
        echo view('back/admin/confirmacionUsuario', ['usuario' => $usuario, 'accion' => $accion]);
        echo view('plantillas/footer');
    }

    public function darDeBajaUsuario($idUsuario){
        $usuarioModel = new Usuarios_model();
        $data = ['baja' => 'SI'];
        $usuarioModel->update($idUsuario, $data);

        session()->setFlashdata('msgExitoso', 'Usuario dado de baja correctamente');
        return redirect()->to('/mostrarListaUsuariosActualizarEliminar');
    }

    public function habilitarUsuario($idUsuario){
        $usuarioModel = new Usuarios_model();
        $data = ['baja' => 'NO'];
        $usuarioModel->update($idUsuario, $data);

        session()->setFlashdata('msgExitoso', 'Usuario habilitado correctamente');
        return redirect()->to('/mostrarListaUsuariosActualizarEliminar');
    }

    public function recibirDatosFormularioUsuario(){
        $datos = $this->request;

        // Si viene de la vista pública de registro
        if(!$datos->getPost('id') && !$datos->getPost('perfil')){
            return $this->validarDatosRegistro($datos);
        }

        // Si viene del admin
        if ($datos->getPost('id')) {
            return $this->validarDatosUsuarioActualizar($datos);
        } else {
            return $this->validarDatosUsuario($datos);
        }
    }

    // CREAR USUARIO (ADMIN)
    public function validarDatosUsuario($datos){
        $session = session();

        $valido = $this->validate([
            'nombre' => ['label' => 'Nombre', 'rules' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]'],
            'apellido' => ['label' => 'Apellido', 'rules' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]'],
            'usuario' => ['label' => 'Usuario', 'rules' => 'required|trim|min_length[4]|max_length[20]|is_unique[usuario.usuario]'],
            'email' => ['label' => 'Correo electrónico', 'rules' => 'required|trim|valid_email|regex_match[/^[\w\.\-]+@[\w\-]+\.(com)$/]|is_unique[usuario.email]'],
            'contraseña' => ['label' => 'Contraseña', 'rules' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/]'],
            'perfil'  => ['label' => 'Perfil', 'rules' => 'required'],
            'barrio' => ['label' => 'Barrio', 'rules' => 'permit_empty|trim|max_length[100]'],
            'calle' => ['label' => 'Calle', 'rules' => 'permit_empty|trim|max_length[100]'],
            'numero' => ['label' => 'Número de calle', 'rules' => 'permit_empty|trim|max_length[11]|is_natural'],
            'localidad'  => ['label' => 'Localidad', 'rules' => 'required']
        ], $datos->getPost());

        $perfilModel = new Perfil_model();
        if(!$perfilModel->validarPerfil($datos->getVar('perfil'))){
            $this->validator->setError('perfil', 'El Perfil seleccionado no es válido.');
            $valido = false;
        }

        $direccionModel = new Direccion_model();
        if(!$direccionModel->validarDireccion($datos->getVar('barrio'), $datos->getVar('calle'), $datos->getVar('numero'))){
            $valido = false;
        }

        $localidadModel = new Localidad_model();
        if(!$localidadModel->validarLocalidad($datos->getVar('localidad'), $datos->getVar('provincia'))){
            $this->validator->setError('localidad', 'La Localidad seleccionada no es válida.');
            $valido = false;
        }

        if(!$valido){
            $session->setFlashdata('usuarioNombreValor', $datos->getVar('nombre'));
            $session->setFlashdata('usuarioApellidoValor', $datos->getVar('apellido'));
            $session->setFlashdata('usuarioUsersValor', $datos->getVar('usuario'));
            $session->setFlashdata('usuarioEmailValor', $datos->getVar('email'));
            $session->setFlashdata('usuarioContraseñaValor', $datos->getVar('contraseña'));
            $session->setFlashdata('usuarioPerfilValor', $datos->getVar('perfil'));
            $session->setFlashdata('usuarioBarrioValor', $datos->getVar('barrio'));
            $session->setFlashdata('usuarioCalleValor', $datos->getVar('calle'));
            $session->setFlashdata('usuarioNumeroValor', $datos->getVar('numero'));
            $session->setFlashdata('usuarioLocalidadValor', $datos->getVar('localidad'));

            return $this->mostrarFormularioCrearUsuario();
        }else{
            return $this->guardarUsuario($datos);
        }
    }

    private function guardarUsuario($datosUsuario){
        $formModel = new Usuarios_model();
        $direccionModel = new Direccion_model();

        $formModel->save([
            'nombre' => $datosUsuario->getVar('nombre'),
            'apellido' => $datosUsuario->getVar('apellido'),
            'usuario' => $datosUsuario->getVar('usuario'),
            'email' => $datosUsuario->getVar('email'),
            'pass' => password_hash($datosUsuario->getVar('contraseña'), PASSWORD_DEFAULT),
            'id_perfil' => $datosUsuario->getVar('perfil'),
        ]);

        $idUsuario = $formModel->getInsertID();

        if ($datosUsuario->getVar('barrio') || $datosUsuario->getVar('calle') || $datosUsuario->getVar('numero') || $datosUsuario->getVar('localidad')) {
            $direccionModel->save([
                'barrio' => $datosUsuario->getVar('barrio'),
                'calle' => $datosUsuario->getVar('calle'),
                'numero' => $datosUsuario->getVar('numero'),
                'id_localidad' => $datosUsuario->getVar('localidad'),
                'id_usuario' => $idUsuario
            ]);
        }

        session()->setFlashdata('msgExitoso', 'Usuario creado correctamente');
        return redirect()->to('/altaDeUsuarios');
    }

    // ACTUALIZAR USUARIO (ADMIN)
    public function validarDatosUsuarioActualizar($datos){
        $id = $datos->getVar('id');

        $valido = $this->validate([
            'id' => ['label' => 'ID Usuario', 'rules' => 'required|numeric'],
            'nombre' => ['label' => 'Nombre', 'rules' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]'],
            'apellido' => ['label' => 'Apellido', 'rules' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]'],
            'usuario' => ['label' => 'Usuario', 'rules' => 'required|trim|min_length[4]|max_length[20]|is_unique[usuario.usuario,id_usuario,' . $id . ']'],
            'email' => ['label' => 'Correo electrónico', 'rules' => 'required|trim|valid_email|regex_match[/^[\w\.\-]+@[\w\-]+\.(com)$/]|is_unique[usuario.email,id_usuario,' . $id . ']'],
            'contraseña' => ['label' => 'Contraseña', 'rules' => 'trim|permit_empty|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/]'],
            'perfil' => ['label' => 'Perfil', 'rules' => 'required'],
            'barrio' => ['label' => 'Barrio', 'rules' => 'permit_empty|trim|max_length[100]'],
            'calle' => ['label' => 'Calle', 'rules' => 'permit_empty|trim|max_length[100]'],
            'numero' => ['label' => 'Número de calle', 'rules' => 'permit_empty|trim|max_length[11]|is_natural'],
            'localidad' => ['label' => 'Localidad', 'rules' => 'required']
        ], $datos->getPost());

        $perfilModel = new Perfil_model();
        if(!$perfilModel->validarPerfil($datos->getVar('perfil'))){
            $this->validator->setError('perfil', 'El Perfil seleccionado no es válido.');
            $valido = false;
        }

        $direccionModel = new Direccion_model();
        if(!$direccionModel->validarDireccion($datos->getVar('barrio'), $datos->getVar('calle'), $datos->getVar('numero'))){
            $valido = false;
        }

        $localidadModel = new Localidad_model();
        if(!$localidadModel->validarLocalidad($datos->getVar('localidad'), $datos->getVar('provincia'))){
            $this->validator->setError('localidad', 'La Localidad seleccionada no es válida.');
            $valido = false;
        }

        if(!$valido){
            return $this->mostrarFormularioActualizarUsuario($id);
        }else{
            return $this->guardarUsuarioActualizado($id, $datos);
        }
    }

    private function guardarUsuarioActualizado($idUsuario, $datosUsuario){
        $data = [
            'nombre' => $datosUsuario->getVar('nombre'),
            'apellido' => $datosUsuario->getVar('apellido'),
            'usuario' => $datosUsuario->getVar('usuario'),
            'email' => $datosUsuario->getVar('email'),
            'id_perfil' => $datosUsuario->getVar('perfil'),
        ];

        $nuevaContraseña = $datosUsuario->getVar('contraseña');
        if (!empty($nuevaContraseña)) {
            $data['pass'] = password_hash($nuevaContraseña, PASSWORD_DEFAULT);
        }

        $usuarioModel = new Usuarios_model();
        $usuarioModel->update($idUsuario, $data);

        $direccionModel = new Direccion_model();
        $direccionData = [
            'barrio' => $datosUsuario->getVar('barrio'),
            'calle' => $datosUsuario->getVar('calle'),
            'numero' => $datosUsuario->getVar('numero'),
            'id_localidad' => $datosUsuario->getVar('localidad'),
            'id_usuario' => $idUsuario
        ];

        $direccionExistente = $direccionModel->where('id_usuario', $idUsuario)->first();
        if ($direccionExistente) {
            $direccionModel->update($direccionExistente['id_direccion'], $direccionData);
        } else {
            $direccionModel->save($direccionData);
        }

        session()->setFlashdata('msgExitoso', 'Los datos del usuario se han guardado correctamente');
        return redirect()->to('/mostrarListaUsuariosActualizarEliminar');
    }

    // REGISTRO DE USUARIO
    public function mostrarFormularioRegistrarse(){
        $categoriaModel = new Categoria_model();
        $dato['categorias'] = $categoriaModel->getCategoriasActivas();
        $marcaModel = new Marca_model();
        $dato['marcas'] = $marcaModel->getMarcasActivas();
        $localidadModel = new Localidad_model();
        $dato['localidades'] = $localidadModel->getLocalidadesActivas();
        $provinciaModel = new Provincia_model();
        $dato['provincias'] = $provinciaModel->getProvinciasActivas();

        $data['titulo'] = 'NetShop | Registro';
        echo view('plantillas/header', $data);
        echo view('plantillas/nav', $dato);
        echo view('back/usuario/registrarse', $dato);
        echo view('plantillas/footer', $dato);
    }

    public function validarDatosRegistro($datos){
        $session = session();

        $valido = $this->validate([
            'nombre' => ['label' => 'Nombre', 'rules' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]'],
            'apellido' => ['label' => 'Apellido', 'rules' => 'required|trim|regex_match[/^([\p{L}\s])+$/u]|min_length[2]|max_length[50]'],
            'usuario' => ['label' => 'Usuario', 'rules' => 'required|trim|min_length[4]|max_length[20]|is_unique[usuario.usuario]'],
            'email' => ['label' => 'Correo electrónico', 'rules' => 'required|trim|valid_email|regex_match[/^[\w\.\-]+@[\w\-]+\.(com)$/]|is_unique[usuario.email]'],
            'contraseña' => ['label' => 'Contraseña', 'rules' => 'required|trim|min_length[8]|max_length[20]|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/]'],
            'barrio' => ['label' => 'Barrio', 'rules' => 'permit_empty|trim|max_length[100]'],
            'calle' => ['label' => 'Calle', 'rules' => 'permit_empty|trim|max_length[100]'],
            'numero' => ['label' => 'Número de calle', 'rules' => 'permit_empty|trim|max_length[11]|is_natural'],
            'localidad'  => ['label' => 'Localidad', 'rules' => 'required']
        ], $datos->getPost());

        $direccionModel = new Direccion_model();
        if(!$direccionModel->validarDireccion($datos->getVar('barrio'), $datos->getVar('calle'), $datos->getVar('numero'))){
            $valido = false;
        }

        $localidadModel = new Localidad_model();
        if(!$localidadModel->validarLocalidad($datos->getVar('localidad'), $datos->getVar('provincia'))){
            $this->validator->setError('localidad', 'La Localidad seleccionada no es válida.');
            $valido = false;
        }

        if(!$valido){
            $session->setFlashdata('validationErrors', $this->validator->getErrors());
            $session->setFlashdata('nombreValor1', $datos->getVar('nombre'));
            $session->setFlashdata('apellidoValor1', $datos->getVar('apellido'));
            $session->setFlashdata('usuarioValor1', $datos->getVar('usuario'));
            $session->setFlashdata('emailValor1', $datos->getVar('email'));
            $session->setFlashdata('passwordValor1', $datos->getVar('contraseña'));
            $session->setFlashdata('barrioValor1', $datos->getVar('barrio'));
            $session->setFlashdata('calleValor1', $datos->getVar('calle'));
            $session->setFlashdata('numeroValor1', $datos->getVar('numero'));
            $session->setFlashdata('localidadValor1', $datos->getVar('localidad'));

            return redirect()->to('/registrarse');
        } else {
            return $this->guardarRegistro($datos);
        }
    }

    private function guardarRegistro($datosRegistro){
        $formModel = new Usuarios_model();
        $direccionModel = new Direccion_model();

        $formModel->save([
            'nombre' => $datosRegistro->getVar('nombre'),
            'apellido' => $datosRegistro->getVar('apellido'),
            'usuario' => $datosRegistro->getVar('usuario'),
            'email' => $datosRegistro->getVar('email'),
            'pass' => password_hash($datosRegistro->getVar('contraseña'), PASSWORD_DEFAULT)
        ]);

        $idUsuario = $formModel->getInsertID();

        if ($datosRegistro->getVar('barrio') || $datosRegistro->getVar('calle') || $datosRegistro->getVar('numero') || $datosRegistro->getVar('localidad')) {
            $direccionModel->save([
                'barrio' => $datosRegistro->getVar('barrio'),
                'calle' => $datosRegistro->getVar('calle'),
                'numero' => $datosRegistro->getVar('numero'),
                'id_localidad' => $datosRegistro->getVar('localidad'),
                'id_usuario' => $idUsuario
            ]);
        }

        session()->setFlashdata('msgExitoso', 'Tu cuenta ha sido creada correctamente');
        return redirect()->to('/registrarse');
    }

    // LIMPIAR DATOS DE FORMULARIOS
    public function limpiarDatosFormularioUsuario($tipo = null, $idUsuario = null) {
        $session = session();

        switch($tipo) {
            case 'registro':
                $session->remove(['nombreValor1', 'apellidoValor1', 'usuarioValor1', 'emailValor1', 'passwordValor1']);
                return redirect()->to('/registrarse');

            case 'altaUsuario':
                $session->remove(['usuarioNombreValor', 'usuarioApellidoValor', 'usuarioUsersValor', 'usuarioEmailValor', 'usuarioContraseñaValor', 'usuarioPerfilValor']);
                return redirect()->to('/altaDeUsuarios');

            case 'actualizarUsuario':
                $session->setFlashdata('limpiarUsuarioValor', true);
                return redirect()->to('/actualizarUsuarios/' . $idUsuario);

            default:
                return redirect()->back();
        }
    }
}