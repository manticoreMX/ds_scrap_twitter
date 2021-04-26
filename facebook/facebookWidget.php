<?php
    $user;
    if(isset($_GET['user']))
        $user = $_GET['user'];
    $timeline = 'false';
    if(isset($_GET['timeline']))
        $timeline = $_GET['timeline'];
    $interval = 5000;
    if(isset($_GET['interval']) && $_GET['interval'] != '')
        $interval = $_GET['interval'];
    $posts = 10;
    if(isset($_GET['posts-limit']))
        $posts = $_GET['posts-limit'];
    $theme = 'light';
        if(isset($_GET['theme']))
            $theme = $_GET['theme'];
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<style>
    body {
        background-color: #f0f2f5;
    }
    .card {
        border-radius: 15px;
    }
    #posts-carousel-content {
        padding: 0 22px;
    }
    .carousel-item {
        max-width: 500px;
    }
    .dark .facebookPost .card{
        background-color: #292F33;
        color: white;
        overflow: hidden;
    }
</style>
<div class="container-fluid mt-4 <?=$theme?>">
    <div id="container" class="row"></div>
</div>
<div id="posts-carousel-content" class="carousel slide <?=$theme?>" data-bs-ride="carousel" data-bs-interval="<?=$interval?>" data-bs-pause="false">
    <div class="carousel-inner"  id="posts-carousel">
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#posts-carousel-content" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#posts-carousel-content" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const user = '<?=$user?>';
        const timeline = '<?=$timeline?>';
        const post = '<?=$posts?>';
        const container = document.getElementById('container');
        const carousel = document.getElementById('posts-carousel');
        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        function paintFacebook() {
            fetch('facebookPaint.php?user=' + user)
            .then(response => {
                response.json()
                .then( r => {
                    if (r.error) {
                        container.innerHTML = 'Espere mientras cargamos los posts...'
                        return;
                    }
                    container.innerHTML = ''
                    carousel.innerHTML = ''
                    r.splice(0, post).forEach((post, index )=> {
                        let div = Object.assign(document.createElement('div'), {
                            className: 'facebookPost ' + ((timeline == 'true') ? 'col-md-4 col-sm-6 mb-4 ' : 'carousel-item ') +  ((index == 0) ? 'active': ''),
                        })
                        let card = Object.assign(document.createElement('div'), {
                            className: 'card',
                        })
                        let divBody = Object.assign(document.createElement('div'), {
                            className: 'card-body',
                        })
                        let title = Object.assign(document.createElement('h5'), {
                            className: 'card-title',
                            innerHTML: `<a href=https://www.facebook.com/"${post.user_id}">${post.username}</a>`
                        })
                        let date = new Date(post.time)
                        let time = Object.assign(document.createElement('h6'), {
                            className: 'card-subtitle mb-2 text-muted',
                            innerHTML: date.getDate() + ' de ' + months[date.getMonth()] + ' a las ' + date.getHours() + ':' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes())
                        })
                        let urlRegex = /(http|ftp|https):\/\/([\w_-]+(?:(?:\.[\w_-]+)+))([\w.,@?^=%&:/~+#-]*[\w@?^=%&/~+#-])?/
                        let catchUrl = post.text.match(urlRegex);
                        let text = Object.assign(document.createElement('div'), {
                            className: 'card-text',
                            innerHTML: catchUrl != null ? post.text.replace(catchUrl[0], `<a href="${catchUrl[0]}">${catchUrl[0]}</a>`) : post.text
                        })
                        let media
                        if (post.image != '') {
                            media = Object.assign(document.createElement('img'), {
                                className: 'card-img-bottom',
                                src: post.image
                            })   
                        } else if (post.video != '') {
                            media = Object.assign(document.createElement('video'), {
                                className: 'card-img-bottom',
                                innerHTML: `<source src="${post.video}" type="video/mp4">`
                            }) 
                            media.setAttribute('controls', true)
                        }
                        divBody.appendChild(title);
                        divBody.appendChild(time);
                        divBody.appendChild(text);
                        card.appendChild(divBody);
                        if (post.image != '' || post.video != ''){
                            card.appendChild(media);
                        }
                        div.appendChild(card);
                        if (timeline == 'true')
                            container.appendChild(div);
                        else
                            carousel.appendChild(div);
                    });
                    setTimeout(() => {
                        var msnry = new Masonry( '#container');
                    }, 2500)
                })
            })
            .catch(error => {
                console.error(error);
            })
        }
        paintFacebook()

        function scrapeUser() {
            fetch('facebookScraping.php?user=' + user)
            .then(response => {
                paintFacebook()
            })
            .catch(r => {
                console.error(r)
            })
        }

        scrapeUser()
    })
</script>