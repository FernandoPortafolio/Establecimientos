const { default: axios } = require('axios')

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('#dropzone')) {
        Dropzone.autoDiscover = false

        const dropzone = new Dropzone('div#dropzone', {
            url: '/images/store',
            paramName: 'image',
            addRemoveLinks: true,
            dictDefaultMessage: 'Sube hasta 10 imágenes',
            dictRemoveFile: 'Borrar archivo',
            dictMaxFilesExceeded: 'Solo puedes subir un máximo de una fotografía',
            acceptedFiles: '.png,.jpg,.jpeg,.gif,.bmp',
            maxFiles: 10,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            },
            init() {
                const galeria = document.querySelectorAll('.galeria')
                const galeria_ids = document.querySelectorAll('.galeria-ids')
                if (galeria.length > 0) {
                    galeria.forEach((image, index) => {
                        const published = {}
                        published.size = 1
                        published.name = image.value
                        published.image_id = galeria_ids[index].value
                        published.uuid = document.querySelector('#uuid').value

                        this.options.addedfile.call(this, published)
                        this.options.thumbnail.call(this, published, `/storage/${published.name}`)

                        published.previewElement.classList.add('dz-success')
                        published.previewElement.classList.add('dz-complete')
                    })
                }
            },
            sending: function(file, xhr, formData) {
                formData.append('uuid', document.querySelector('#uuid').value)
            },
            success: function(file, response) {
                file.path = response.path
                file.image_id = response.image_id
            },
            removedfile: async function(file) {
                const id = file.image_id
                const resp = await axios.delete(`/images/${id}/destroy`)
                console.log(resp)
                file.previewElement.parentNode.removeChild(file.previewElement)
            },
        })
    }
})
