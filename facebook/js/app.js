document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    const url = "http://localhost/multimediacorp/facebook/facebookWidget.php"
    const page = document.getElementById('page')
    const timeline = document.getElementById('timeline')
    const interval = document.getElementById('interval')
    const intervalContent = document.getElementById('interval-content')
    const chrome = document.getElementsByClassName('chrome')
    const tweetLimit = document.getElementById('tweet-limit')
    const getLink = document.getElementById('get-link')
    const generarLink = document.getElementById('generar-link')
    const copyText = document.getElementById('copy-text')

    generarLink.addEventListener('click', () => {
        let chromeValues = '';
        for (const v of chrome) {
            if (v.checked) chromeValues += v.value + '-'
        }
        const link = `${url}?user=${page.value}&timeline=${timeline.checked}&posts-limit=${tweetLimit.value}&interval=${interval.value}`
        getLink.value = link;
    })

    timeline.addEventListener('click', () => {
        if (timeline.checked) {
            intervalContent.style.display = 'none'
        } else {
            intervalContent.style.display = 'block'
        }
    })

    copyText.addEventListener('click', () => {
        getLink.select();
        getLink.setSelectionRange(0, 99999)
        document.execCommand("copy")
    })
});


