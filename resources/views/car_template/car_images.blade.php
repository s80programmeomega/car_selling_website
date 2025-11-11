@extends('car_template.base')

@section('title', 'Car Images - Car Selling Website')

@section('content')
<div>
    <div class="container">
        <h1 class="car-details-page-title">
            Manage Images for: 2016 - Lexus RX200t
        </h1>

        <div class="car-images-wrapper">
            <form action="" method="POST" class="card p-medium form-update-images">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Delete</th>
                                <th>Image</th>
                                <th>Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_images[]" id="delete_image_1" value="1" />
                                </td>
                                <td>
                                    <img src="/img/cars/Lexus-RX200t-2016/1.jpeg" alt="" class="my-cars-img-thumbnail"
                                        style="width: 120px" />
                                </td>
                                <td>
                                    <input type="number" name="positions[1]" value="1" style="width: 80px" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_images[]" id="delete_image_2" value="2" />
                                </td>
                                <td>
                                    <img src="/img/cars/Lexus-RX200t-2016/2.jpeg" alt="" class="my-cars-img-thumbnail"
                                        style="width: 120px" />
                                </td>
                                <td>
                                    <input type="number" name="positions[2]" value="2" style="width: 80px" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_images[]" id="delete_image_3" value="3" />
                                </td>
                                <td>
                                    <img src="/img/cars/Lexus-RX200t-2016/3.jpeg" alt="" class="my-cars-img-thumbnail"
                                        style="width: 120px" />
                                </td>
                                <td>
                                    <input type="number" name="positions[3]" value="3" style="width: 80px" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_images[]" id="delete_image_4" value="4" />
                                </td>
                                <td>
                                    <img src="/img/cars/Lexus-RX200t-2016/4.jpeg" alt="" class="my-cars-img-thumbnail"
                                        style="width: 120px" />
                                </td>
                                <td>
                                    <input type="number" name="positions[4]" value="4" style="width: 80px" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_images[]" id="delete_image_5" value="5" />
                                </td>
                                <td>
                                    <img src="/img/cars/Lexus-RX200t-2016/5.jpeg" alt="" class="my-cars-img-thumbnail"
                                        style="width: 120px" />
                                </td>
                                <td>
                                    <input type="number" name="positions[5]" value="5" style="width: 80px" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_images[]" id="delete_image_6" value="6" />
                                </td>
                                <td>
                                    <img src="/img/cars/Lexus-RX200t-2016/6.jpeg" alt="" class="my-cars-img-thumbnail"
                                        style="width: 120px" />
                                </td>
                                <td>
                                    <input type="number" name="positions[6]" value="6" style="width: 80px" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_images[]" id="delete_image_7" value="7" />
                                </td>
                                <td>
                                    <img src="/img/cars/Lexus-RX200t-2016/7.jpeg" alt="" class="my-cars-img-thumbnail"
                                        style="width: 120px" />
                                </td>
                                <td>
                                    <input type="number" name="positions[7]" value="7" style="width: 80px" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="p-medium" style="width: 100%">
                    <div class="flex justify-end gap-1">
                        <button class="btn btn-primary">Update Images</button>
                    </div>
                </div>
            </form>
            <form action="" method="POST" enctype="multipart/form-data" class="card form-images p-medium mb-large">
                <div class="form-image-upload">
                    <div class="upload-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 48px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <input id="carFormImageUpload" type="file" name="images[]" multiple accept="image/*" />
                </div>
                <div id="imagePreviews" class="car-form-images"></div>

                <div class="p-medium" style="width: 100%">
                    <div class="flex justify-end gap-1">
                        <button class="btn btn-primary">Add Images</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
