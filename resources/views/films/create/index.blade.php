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
                        <h3 class="card-label">Crear film
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Título</label>
                                <input type="text" class="form-control" v-model="name">
                                <small v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Género</label>
                                <input type="text" class="form-control" v-model="genre">
                                <small v-if="errors.hasOwnProperty('genre')">@{{ errors['genre'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Formato</label>
                                <input type="text" class="form-control" v-model="format">
                                <small v-if="errors.hasOwnProperty('format')">@{{ errors['format'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Año</label>
                                <input type="text" class="form-control" v-model="year">
                                <small v-if="errors.hasOwnProperty('year')">@{{ errors['year'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Duración</label>
                                <input type="text" class="form-control" v-model="duration">
                                <small v-if="errors.hasOwnProperty('duration')">@{{ errors['duration'][0] }}</small>
                                
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Sinopsis</label>
                                <textarea rows="3" id="editorDescription"></textarea>
                                <small v-if="errors.hasOwnProperty('description')">@{{ errors['description'][0] }}</small>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Imágen (1024x900px | max: 8 Mb )</label>
                                <p>
                                    <button @click="uploadImage()" class="btn btn-info">Imágen portada</button>
                                </p>

                                <img v-if="imageFileType == 'image'" :src="imagePreview" style="width: 40%;">
                                <video class="w-100" controls v-if="imagePreview != '' && imagePreview == 'video'">
                                    <source :src="imagePreview" type="video/mp4">
                                    <source :src="imagePreview" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>

                                <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Imágen o video (1024x900px | max: 8 Mb )</label>
                                <p>
                                    <button @click="openSecondaryImageUpload()" class="btn btn-info">Imágen o video</button>
                                </p>

                                <img v-if="secondaryFileType == 'image'" :src="secondaryPreviewPicture" style="width: 40%;">
                                <video class="w-100" controls v-if="secondaryPreviewPicture != '' && secondaryFileType == 'video'">
                                    <source :src="secondaryPreviewPicture" type="video/mp4">
                                    <source :src="secondaryPreviewPicture" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>

                                <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">
                                <button class="btn btn-success" @click="store()">Crear</button>
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
    <script src="{{ url('ckeditor/build/ckeditor.js') }}"></script>
    <script src="https://upload-widget.cloudinary.com/global/all.js" type="text/javascript"></script>  

    @include("films.create.script")

@endpush
