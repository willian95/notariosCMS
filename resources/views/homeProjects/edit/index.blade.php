@extends("layouts.main")

@section("content")


    <div class="d-flex flex-column-fluid" id="dev-app">
        <div class="loader-cover-custom" v-if="loading == true">
			<div class="loader-custom"></div>
		</div>
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Editar proyecto
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Título</label>
                                <input type="text" class="form-control" v-model="title">
                                <small v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Director</label>
                                <input type="text" class="form-control" v-model="director">
                                <small v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Orden</label>
                                <input type="text" class="form-control" v-model="order">
                                <small v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Vídeo Intro</label>
                                <p>
                                    <button @click="uploadImage()" class="btn btn-info">Upload files</button>
                                </p>

                                <video class="w-100" controls v-if="imagePreview != ''">
                                    <source :src="imagePreview" type="video/mp4">
                                    <source :src="imagePreview" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>

                                <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Vídeo comercial</label>
                                <p>
                                    <button @click="uploadImage2()" class="btn btn-info">Upload files</button>
                                </p>

                                <video class="w-100" controls v-if="videoComercialPreview != ''">
                                    <source :src="videoComercialPreview" type="video/mp4">
                                    <source :src="videoComercialPreview" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>

                                <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">
                                <button class="btn btn-success" @click="update()">Actualizar</button>
                            </p>
                        </div>
                    </div>


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->


    </div>

@endsection

@push("scripts")

    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>  

    @include("homeProjects.edit.script")

@endpush
