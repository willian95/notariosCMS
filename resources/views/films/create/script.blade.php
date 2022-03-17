<script src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script>
    
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{

                loading:false,
                name:"",
                errors:[],

                editorDescriptionField:"",
                genre:"",
                format:"",
                year:"",
                duration:"",
                description:"",

                imagePreview:"",
                imageFileType:"",
                finalPictureName:"",

                secondaryPicture:"",
                secondaryPreviewPicture:"",
                secondaryFileType:"",

                
            }
        },
        methods:{
            
            store(){

                this.loading = true
                axios.post("{{ route('films.store') }}", {
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
                            text: "Film creado!",
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
                        cloudName: 'laliberty', 
                        uploadPreset: 'test_notarios',
                        api_key:'913447513718925',
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
                        cloudName: 'laliberty', 
                        uploadPreset: 'test_notarios',
                        api_key:'913447513718925',
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