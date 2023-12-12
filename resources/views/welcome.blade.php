@extends('layout')

@section('content')

 
<h1>Documento: <?php echo $DocumentoData->Nombre; ?></h1>
<iframe src="<?php echo $url; ?>" width="800" height="600"></iframe>
 



@endsection
	

@push('scripts') 
	 

    <!-- <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
        }); 
	</script> -->

     


     
@endpush