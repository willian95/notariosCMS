<script src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script>
    
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{

                id:"{{ $director->id }}",
                loading:false,
                name:"{{ $director->name }}",
                type:"{{$director->type}}",
                errors:[],

                editorDescriptionField:"",
                vimeoLink:"{{ $director->vimeo_link }}",
                workImagesFirst:JSON.parse('{!! $directorContent !!}'),
                imagesToUpload:[],
                workImages:[],
                secondaryPreviewPicture:"",
                secondaryPicture:"",

                imagePreview:"{{ $director->image }}",
                imageFileType:"image",
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
                axios.post("{{ route('services.update') }}", {
                    id: this.id,
                    type:this.type,
                    name:this.name, 
                    workImages: this.imagesToUpload, 
                }).then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            title: "Excelente!",
                            text: res.data.msg,
                            icon: "success"
                        }).then(function() {
                            window.location.href = "{{ route('services.list') }}";
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

            this.workImagesFirst.forEach((data) => {
                this.workImages.push({finalName:data.image, type: data.type})
            })
        }

    })

</script>