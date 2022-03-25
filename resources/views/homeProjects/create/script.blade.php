<script src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script>
    
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{

                loading:false,
                name:"",
                errors:[],

                title:"",
                director:"",
                order:"",
                imagePreview:"",
                imageFileType:"video",
                finalPictureName:"",
                videoComercialPreview:"",
                videoComercialName:""

                
            }
        },
        methods:{
            
            store(){

                this.loading = true
                axios.post("{{ route('home.store') }}", {
                    title:this.title, 
                    director:this.director,
                    image: this.finalPictureName,
                    comercial: this.videoComercialName,
                    order: this.order
                }).then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            title: "Excelente!",
                            text: "Proyecto creado!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "{{ route('home.index') }}";
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
                     
                            this.imagePreview = result.info.secure_url
                            this.finalPictureName = result.info.secure_url

                        }
                    }
                )

                myWidget.open()

            },

            uploadImage2(){

                var myWidget = cloudinary.createUploadWidget({
                        cloudName: 'laliberty', 
                        uploadPreset: 'test_notarios',
                        api_key:'913447513718925',
                        sources: [ 'local', 'url', 'image_search'],
                    }, (error, result) => { 
                        if (!error && result && result.event === "success") { 
                    
                            this.videoComercialPreview = result.info.secure_url
                            this.videoComercialName = result.info.secure_url

                        }
                    }
                )

                myWidget.open()

            },



        },
        mounted(){


        }

    })

</script>