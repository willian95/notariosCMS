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
                vimeoLink:"",
                imagesToUpload:[],
                workImages:[],
                secondaryPreviewPicture:"",
                secondaryPicture:"",

                imagePreview:"",
                imageFileType:"image",
                finalPictureName:"test",

                secondaryPicture:"",
                secondaryPreviewPicture:"",
                secondaryFileType:"",
                fileName:""

                
            }
        },
        methods:{
            
            store(){

                this.workImages.forEach((data) => {
                    this.imagesToUpload.push({finalName:data.finalName, type: data.type})
                })

                this.loading = true
                axios.post("{{ route('directors.store') }}", {
                    description:this.editorDescriptionField.getData(),
                    vimeo_link:this.vimeoLink,
                    name:this.name, 
                    image: this.finalPictureName, 
                    workImages: this.imagesToUpload, 
                    mainImageFileType: this.imageFileType
                }).then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            title: "Excelente!",
                            text: "Director creado!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "{{ route('directors.list') }}";
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
            
            
            deleteWorkImage(index){

                this.workImages.splice(index, 1)

            },

            uploadImage(){

                var myWidget = cloudinary.createUploadWidget({
                        cloudName: 'duewi8k6b', 
                        api_key:'717481689751616',
                        uploadPreset: 'notarios',
                        sources: [ 'local', 'url', 'image_search'],
                    }, (error, result) => { 
                        if (!error && result && result.event === "success") { 
                            console.log('Done! Here is the image info: ', result.info); 

                            this.imageFileType = result.info.resource_type
                            this.imagePreview = result.info.secure_url
                            this.finalPictureName = result.info.secure_url

                            console.log(this.imageFileType)

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
                            console.log('Done! Here is the image info: ', result.info); 


                            this.workImages.push({image: result.info.secure_url, finalName: result.info.secure_url, originalName: result.info.original_filename, "type": result.info.resource_type})

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