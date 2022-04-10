<script src="{{ url('ckeditor/ckeditor.js') }}"></script>
<script>
    
    const app = new Vue({
        el: '#dev-app',
        data(){
            return{

                loading:false,
                name:"",
                errors:[],
                id:"{{ $data->id }}",

                title:"{{ $data->title }}",
                director:"{{ $data->director }}",
                order:"{{ $data->order }}",
                imagePreview:"{{ $data->video }}",
                imageFileType:"video",
                finalPictureName:"",
                videoComercialPreview:"{{ $data->video_comercial }}",
                videoComercialName:""

                
            }
        },
        methods:{
            
            update(){

                this.loading = true
                axios.post("{{ route('home.update') }}", {
                    id:this.id,
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
                            text: res.data.message,
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
                        cloudName: 'duewi8k6b', 
                        api_key:'717481689751616',
                        uploadPreset: 'notarios',
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
                        cloudName: 'duewi8k6b', 
                        api_key:'717481689751616',
                        uploadPreset: 'notarios',
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