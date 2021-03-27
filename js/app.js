document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    const url = "http://localhost/multimediacorp/twitterWidget.php"
    const page = document.getElementById('page')
    const timeline = document.getElementById('timeline')
    const showReplies = document.getElementById('show-replies')
    const theme = document.getElementById('theme')
    const dnt = document.getElementById('dnt')
    const chrome = document.getElementsByClassName('chrome')
    const width = document.getElementById('width')
    const height = document.getElementById('height')
    const tweetLimit = document.getElementById('tweet-limit')
    const getLink = document.getElementById('get-link')
    const generarLink = document.getElementById('generar-link')

    generarLink.addEventListener('click', () => {
        let chromeValues = '';
        for (const v of chrome) {
            if (v.checked) chromeValues += v.value + '-'
        }
        const link = `${url}?page=${page.value}&timeline=${timeline.checked}&show-replies=${showReplies.checked}&dnt=${dnt.checked}&theme=${theme.checked? 'dark' : 'light'}&chrome=${chromeValues.slice(0,-1)}&width=${width.value||0}&height=${height.value||0}&tweet-limit=${tweetLimit.value}`
        getLink.value = link;
    })
});


