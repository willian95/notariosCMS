<script src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script>
    
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{

                id:"{{ $film->id }}",
                loading:false,
                name:"{{ $film->genre }}",
                errors:[],

                editorDescriptionField:"",
                genre:"{{ $film->genre }}",
                format:"{{ $film->format }}",
                year:"{{ $film->year }}",
                duration:"{{ $film->duration }}",
                description:"",

                imagePreview:"{{ $film->image }}",
                imageFileType:"{{ $film->main_image_file_type }}",
                finalPictureName:"",

                secondaryPicture:"",
                secondaryPreviewPicture:"{{ $film->secondary_image }}",
                secondaryFileType:"{{ $film->secondary_image_file_type }}",

                
            }
        },
        methods:{
            
            update(){

                this.loading = true
                axios.post("{{ route('films.update') }}", {
                    id:"{{ $film->id }}",
                    description:this.editorDescriptionField.getData(),
                    genre:this.genre,
                    name:this.name, 
                    format:this.format,
                    year:this.year,
                    duration:this.duration,
                    image: this.finalPictureName, 
                    mainImageFileType: this.imageFileType,
                    secondaryImage:this.secondaryPicture,
                    secondaryImageFileType: this.secondaryFileType
                }).then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            title: "Excelente!",
                            text: "Film actualizado!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "{{ route('films.list') }}";
                        });
                        

                    }else{
                    
                        alert(res.data.msg)
                    }

                }).catch(err => {
                    
                    this.loading = false
                    this.errors = err.response.data.errors
                    
                    swal({
                        text: "Hay campos que debes verificar!",
                        icon: "warning"
                    })
                
                })

            },

            uploadImage(){

                var myWidget = cloudinary.createUploadWidget({
                        cloudName: 'duewi8k6b', 
                        api_key:'717481689751616',
                        uploadPreset: 'notarios',
                        sources: [ 'local', 'url', 'image_search'],
                    }, (error, result) => { 
                        if (!error && result && result.event === "success") { 

                            this.imageFileType = result.info.resource_type
                            this.imagePreview = result.info.secure_url
                            this.finalPictureName = result.info.secure_url

                        }
                    }
                )

                myWidget.open()

            },

            openSecondaryImageUpload(){

                var myWidget = cloudinary.createUploadWidget({
                        cloudName: 'duewi8k6b', 
                        api_key:'717481689751616',
                        uploadPreset: 'notarios',
                        sources: [ 'local', 'url', 'image_search'],
                    }, (error, result) => { 
                        if (!error && result && result.event === "success") { 
                            
                            this.secondaryFileType = result.info.resource_type
                            this.secondaryPreviewPicture = result.info.secure_url
                            this.secondaryPicture = result.info.secure_url

                        }
                    }
                )

                myWidget.open()

            },
            async createEditor(idTag){

                const editor = await ClassicEditor.create( document.querySelector( '#'+idTag ) )
                if(idTag == "editorDescription"){
                    this.editorDescriptionField = editor
                }


            }


        },
        mounted(){
            
            //CKEDITOR.replace( 'editor1' );
            this.createEditor("editorDescription")

        }

    })

</script>