<script src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script>
    
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{

                loading:false,
                name:"",
                errors:[],

                imagesToUpload:[],
                workImages:[],
                secondaryPreviewPicture:"",
                secondaryPicture:"",

                imagePreview:"",
                imageFileType:"",
                finalPictureName:"",

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
                axios.post("{{ route('projects.store') }}", {
                    name:this.name, 
                    image: this.finalPictureName, 
                    workImages: this.imagesToUpload, 
                    mainImageFileType: this.imageFileType
                }).then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            title: "Excelente!",
                            text: "Proyecto creado!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "{{ route('projects.list') }}";
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
                        cloudName: 'laliberty', 
                        uploadPreset: 'test_notarios',
                        api_key:'913447513718925',
                        sources: [ 'local', 'url', 'image_search'],
                    }, (error, result) => { 
                        if (!error && result && result.event === "success") { 
                            console.log('Done! Here is the image info: ', result.info); 

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
                            console.log('Done! Here is the image info: ', result.info); 


                            this.workImages.push({image: result.info.secure_url, finalName: result.info.secure_url, originalName: result.info.original_filename, "type": result.info.format == "pdf" ? "pdf" : result.info.resource_type })

                        }
                    }
                )

                myWidget.open()

            }


        },
        mounted(){
            
            //CKEDITOR.replace( 'editor1' );

        }

    })

</script>