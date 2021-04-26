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
    .dark .instagramPost .card{
        background-color: #292F33;
        color: white;
        overflow: hidden;
    }
</style>
<div class="container-fluid mt-4 <?=$theme?>">
    <div id="container" class="row">Espere mientras cargamos los posts...</div>
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
        function paintInstagram() {
            fetch(`scrap/${user}/${user}.json`)
            .then(response => {
                response.json()
                .then( r => {
                    if (r.error) {
                        container.innerHTML = 'Espere mientras cargamos los posts...'
                        return;
                    }
                    //return
                    container.innerHTML = ''
                    carousel.innerHTML = ''
                    r.GraphImages.splice(0, post).forEach((post, index )=> {
                        let div = Object.assign(document.createElement('div'), {
                            className: 'instagramPost ' + ((timeline == 'true') ? 'col-md-4 col-sm-6 mb-4 ' : 'carousel-item ') +  ((index == 0) ? 'active': ''),
                        })
                        let card = Object.assign(document.createElement('div'), {
                            className: 'card',
                        })
                        let divBody = Object.assign(document.createElement('div'), {
                            className: 'card-body',
                        })
                        let title = Object.assign(document.createElement('h5'), {
                            className: 'card-title',
                            innerHTML: `<a href="https://www.instagram.com/${post.username}">${post.username}</a>`
                        })
                        let date = new Date(post.taken_at_timestamp)
                        let time = Object.assign(document.createElement('h6'), {
                            className: 'card-subtitle mb-2 text-muted',
                            innerHTML: date.getDate() + ' de ' + months[date.getMonth()] + ' a las ' + date.getHours() + ':' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes())
                        })
                        let text = Object.assign(document.createElement('div'), {
                            className: 'card-text',
                            innerHTML: post.edge_media_to_caption.edges[0].node.text
                        })
                        let media
                        if (post.__typename == "GraphImage") {
                            media = Object.assign(document.createElement('img'), {
                                className: 'card-img-bottom',
                                src: post.display_url
                            })   
                        } else if (post.__typename == "GraphVideo") {
                            media = Object.assign(document.createElement('video'), {
                                className: 'card-img-bottom',
                                innerHTML: `<source src="${post.urls[0]}" type="video/mp4">`
                            }) 
                            media.setAttribute('controls', true)
                        } else {
                            media = Object.assign(document.createElement('img'), {
                                className: 'card-img-bottom',
                                src: post.urls[0]
                            })
                        }
                        divBody.appendChild(title);
                        divBody.appendChild(time);                        
                        divBody.appendChild(text);
                        card.appendChild(divBody);
                        card.appendChild(media);
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
        paintInstagram()

        function scrapeUser() {
            fetch('scrap/instagramScraping.php?user=' + user)
            .then(response => {
                paintInstagram()
            })
            .catch(r => {
                console.error(r)
            })
        }

        scrapeUser()
    })
</script>