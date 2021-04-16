document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    const url = "http://localhost/multimediacorp/twitter/twitterWidget.php"
    const page = document.getElementById('page')
    const timeline = document.getElementById('timeline')
    const showReplies = document.getElementById('show-replies')
    const theme = document.getElementById('theme')
    const dnt = document.getElementById('dnt')
    const interval = document.getElementById('interval')
    const intervalContent = document.getElementById('interval-content')
    const chrome = document.getElementsByClassName('chrome')
    const width = document.getElementById('width')
    const height = document.getElementById('height')
    const tweetLimit = document.getElementById('tweet-limit')
    const getLink = document.getElementById('get-link')
    const generarLink = document.getElementById('generar-link')
    const copyText = document.getElementById('copy-text')

    generarLink.addEventListener('click', () => {
        let chromeValues = '';
        for (const v of chrome) {
            if (v.checked) chromeValues += v.value + '-'
        }
        const link = `${url}?page=${page.value}&timeline=${timeline.checked}&show-replies=${showReplies.checked}&dnt=${dnt.checked}&theme=${theme.checked? 'dark' : 'light'}&chrome=${chromeValues.slice(0,-1)}&width=${width.value||0}&height=${height.value||0}&tweet-limit=${tweetLimit.value}&interval=${interval.value}`
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
        document.execCommand("copy");
    })
});


