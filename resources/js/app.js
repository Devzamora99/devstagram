import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,

    //Esta funcion se inicia cuando el dropzone es creado
    init: function () {
        if (document.querySelector('[name="imagen"]').value.trim()) {
            const imagenPublicada = {}; //Objeto vacio
            imagenPublicada.size = 1234; //El tamaño a utilizar en este caso no es importante
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;
            
            //Funcion del dropzone para llamar la imagen
            this.options.addedfile.call(this, imagenPublicada);
            //Establecer la ruta de la imagen
            this.opcions.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`)
            //Generando el preview de la imagen utilizando metodos de dropzone
            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
        }
    }
});

//Evento encargado de activarse cuando se ha subido correctamente el archivo
dropzone.on('success', function (file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen;
})

//Evento encargado de activarse cuando se ha eliminado el archivo
dropzone.on('removedfile', function () {
    document.querySelector('[name="imagen"]').value = "";
})