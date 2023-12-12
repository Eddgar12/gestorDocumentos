<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>El Colef - NORMATECA INTERNA </title>
        <script
        src="https://code.jquery.com/jquery-3.6.1.min.js" 
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
        crossorigin="anonymous"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

        <!-- css: vite js  -->
        <link href="{{ URL::asset('css/principal.css') }}" rel="stylesheet">
        <!-- <link href="{{ URL::asset('js/funciones.js') }}" rel="stylesheet"> -->
        <script src="{{ asset('js/funciones.js') }}"></script>
        <script src="{{ asset('js/principal.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>

        <script src="https://cdn.tiny.cloud/1/nzpyavlvgfstt2wwxg8taefexxpgq4se75xksorhp5dnlxt6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        <script src="https://kit.fontawesome.com/ea26eb8a4d.js" crossorigin="anonymous"></script>
        <!-- DataTables CDNs -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" crossorigin="anonymous"/>
        <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>  
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light navbar-laravel navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">El Colef</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                         
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-users"></i>  CVs </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Documentos
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
                                <li class="dropdown-item">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-file"></i> 1. Crear</a>
                                </li>

                                <li class="dropdown-item">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-list-check"></i> 2. Revisión</a>
                                </li>

                                <li class="dropdown-item">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-file-signature"></i> 3. Firma</a>
                                </li>

                                <li class="dropdown-item">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-share-nodes"></i> 4. Oficialía de parte</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-calendar-day"></i>  Eventos </a>
                        </li> 

                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-solid fa-user"></i>  Usuarios externos </a>
                        </li> 

                        <li class="nav-item">
                            <a class="nav-link" href="#">
                            Oficios
                            </a>
                        </li>
 
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Administración DSI
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
                                <li class="dropdown-item">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-cloud-arrow-down"></i> 1. Importar empleados de SIPA</a>
                                </li>


                                <li class="dropdown-item">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-cloud-arrow-down"></i> 2. Importar investigadores de SIPA</a>
                                </li>

                                <li class="dropdown-item">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-cloud-arrow-down"></i> 3. Importar informacion de investigadores de Portal</a>

                                </li>

                                <li class="dropdown-item">
                                    <a class="nav-link" href="#"><i class="fa-solid fa-cloud-arrow-down"></i> 4. Catalogos de eventos</a>
                                </li>

                            </ul>
                        </li>
 
                    </ul>
                </div>
                 
            </div>
        </nav>
        @yield('content')

        @stack('scripts')
    </body>
    
     
</html>