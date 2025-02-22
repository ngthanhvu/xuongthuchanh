@extends('layouts.master')
@section('content')
<style>
    /* Reset cơ bản */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        width: 100%;
        font-family: 'Arial', sans-serif;
        color: #333;
    }

    /* Container tổng */
    ._container_juuyp_1 {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
    }

    /* Phần tiêu đề và mô tả */
    ._container-top_juuyp_10 {
        text-align: center;
        margin-bottom: 40px;
    }

    ._heading_juuyp_22 {
        font-weight: bold;
        font-size: 1.5rem;
        margin-right: 1010px;
        margin-bottom: 30px;
        color: #222;
    }

    ._wrapper_1ek85_1 {
        max-width: 600px;
        justify-content: left;
    }

    ._wrapper_1ek85_1 p {
        font-size: 15px;
    }

    ._desc_juuyp_29 p {
       
    }

    /* Phần nội dung (các card lộ trình) */
    .container-body {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    /* Card lộ trình */
    ._content_j5ws2_1 {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    ._wrapper_1qw7z_1 {
        width: calc(50% - 10px);
        height: 250px;
        border: 2px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: box-shadow 0.3s ease;
    }

    ._wrapper_1qw7z_1:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    ._body_1qw7z_13 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    ._info_1qw7z_18 {
        flex: 1;
    }

    ._title_1qw7z_22 {
        font-size: 1.8rem;
        margin-bottom: 10px;
    }

    ._title_1qw7z_22 a {
        font-size: 25px;
        text-decoration: none;
        color: rgb(0, 0, 0);
        font-weight: 700;
        transition: color 0.3s ease;
    }

    ._desc_1qw7z_33 {
        font-size: 16px;
        color: #555;
    }

    ._thumb-wrap_1qw7z_39 {
        margin-left: 15px;
    }

    ._thumb-round_1qw7z_45 {
        display: block;
        width: 100px;
        height: 100px;
        overflow: hidden;
        border-radius: 50%;
    }

    ._thumb_1qw7z_39 {
        padding: 10px 10px;
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50px;
        border: 5px solid #ff7f00;
    }

    /* Nút xem chi tiết */
    ._wrapper_1kk55_1 {
        display: inline-block;
    }

    ._view-detail_1qw7z_83 {
        display: inline-block;
        background-color:rgb(44, 139, 240);
        color: #fff;
        font-size: 1px;
        padding: 5px 25px;
        text-decoration: none;
        border-radius: 20px;
        transition: background-color 0.3s ease;
        text-align: center;
    }

    ._view-detail_1qw7z_83:hover {
        background-color:rgb(32, 116, 205);
        color: #fff;
    }

    ._inner_1kk55_33 {
        display: flex;
        align-items: center;
    }

    ._title_1kk55_61 {
        font-size: 1.1rem;
    }

    /* Phần tham gia cộng đồng */
    ._wrapper_669bc_1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px;
        border-radius: 8px;
    }

    ._info_669bc_9 {
        max-width: 40%;
    }

    ._info_669bc_9 h2 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: #222;
        font-weight: 700;
    }

    ._info_669bc_9 p {
        font-size: 1rem;
        margin-bottom: 15px;
        color: #555;
    }

    ._cta_669bc_32 {
        display: inline-block;
        background-color:rgb(255, 255, 255);
        color: black;
        padding: 8px 20px;
        text-decoration: none;
        border: solid 2px black;
        border-radius: 20px;
        transition: background-color 0.3s ease;
    }

    ._cta_669bc_32:hover {
        background-color:rgb(0, 0, 0);
        color: #fff;
    }

    ._image_669bc_26 img {
       width: 400px;
        height: 400px;
        border-radius: 8px;
        position: absolute;
    }
    ._image_669bc_26 img {
        top: 650px;
        right: 70px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        ._content_j5ws2_1 {
            flex-direction: column;
        }

        ._wrapper_1qw7z_1 {
            width: 100px;
        }

        ._wrapper_669bc_1 {
            flex-direction: column;
            text-align: center;
        }

        ._info_669bc_9 {
            max-width: 100%;
        }

        ._image_669bc_26 {
            margin-top: 20px;
        }
    }
</style>
<div class="_container_juuyp_1">
    <div class="_container-top_juuyp_10">
        <h1 class="_heading_juuyp_22">Lộ trình học</h1>
        <div class="_wrapper_1ek85_1 _desc_juuyp_29" style="--font-size: 1.4rem; --line-height: 1.8;">
            <p>Để bắt đầu một cách thuận lợi, bạn nên tập trung vào một lộ trình học. Ví dụ: Để đi làm với vị trí "Lập trình viên Front-end" bạn nên tập trung vào lộ trình "Front-end".</p>
        </div>
    </div>
    <div class="container-body">
        <div class="_content_j5ws2_1" style="margin-top: 50px;">
            <div class="_wrapper_1qw7z_1">
                <div class="_body_1qw7z_13">
                    <div class="_info_1qw7z_18">
                        <h2 class="_title_1qw7z_22"><a href="/learning-paths/front-end-development">Lộ trình học Front-end</a></h2>
                        <p class="_desc_1qw7z_33">Lập trình viên Front-end là người xây dựng ra giao diện websites. Trong phần này F8 sẽ chia sẻ cho bạn lộ trình để trở thành lập trình viên Front-end nhé.</p>
                    </div>
                    <div class="_thumb-wrap_1qw7z_39"><a class="_thumb-round_1qw7z_45" href="/learning-paths/front-end-development"><img class="_thumb_1qw7z_39" src="https://files.fullstack.edu.vn/f8-prod/learning-paths/2/63b4642136f3e.png" alt="Lộ trình học Front-end"></a></div>
                </div>
                <div><a type="button" href="/learning-paths/front-end-development" class=" _view-detail_1qw7z_83 _primary_1kk55_46 _rounded_1kk55_22"><span class="_inner_1kk55_33"><span class="_title_1kk55_61">Xem chi tiết</span></span></a></div>
            </div>
            <div class="_wrapper_1qw7z_1">
                <div class="_body_1qw7z_13">
                    <div class="_info_1qw7z_18">
                        <h2 class="_title_1qw7z_22"><a href="/learning-paths/back-end-development">Lộ trình học Back-end</a></h2>
                        <p class="_desc_1qw7z_33">Trái với Front-end thì lập trình viên Back-end là người làm việc với dữ liệu, công việc thường nặng tính logic hơn. Chúng ta sẽ cùng tìm hiểu thêm về lộ trình học Back-end nhé.</p>
                    </div>
                    <div class="_thumb-wrap_1qw7z_39"><a class="_thumb-round_1qw7z_45" href="/learning-paths/back-end-development"><img class="_thumb_1qw7z_39" src="https://files.fullstack.edu.vn/f8-prod/learning-paths/3/63b4641535b16.png" alt="Lộ trình học Back-end"></a></div>
                </div>
                <div><a type="button" href="/learning-paths/back-end-development" class="_wrapper_1kk55_1 _view-detail_1qw7z_83 _primary_1kk55_46 _rounded_1kk55_22"><span class="_inner_1kk55_33"><span class="_title_1kk55_61">Xem chi tiết</span></span></a></div>
            </div>
        </div>
        <div class="_wrapper_669bc_1" style="margin-top: 140px; margin-bottom: 100px;">
            <div class="_info_669bc_9">
                <h2>Tham gia cộng đồng học viên F8 trên Facebook</h2>
                <p>Hàng nghìn người khác đang học lộ trình giống như bạn. Hãy tham gia hỏi đáp, chia sẻ và hỗ trợ nhau
                    trong quá trình học nhé.</p><a class="_cta_669bc_32" target="_blank" href="https://www.facebook.com/groups/f8official" rel="noopener">Tham gia nhóm</a>
            </div>
            <div class="_image_669bc_26"><img src="https://fullstack.edu.vn/assets/fb-group-cards-CAn_kGMe.png" alt="Học lập trình web (F8 - Fullstack.edu.vn)"></div>
        </div>
    </div>
</div>
@endsection