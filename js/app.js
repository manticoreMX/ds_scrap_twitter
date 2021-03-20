$(document).ready(function(){
    M.AutoInit();
    const showReplies = $('#show-replies')
    const theme = $('#theme')
    const dnt = $('#dnt')
    const chrome = $('.chrome')
    const width = $('#width')
    const height = $('#height')
    const tweetLimit = $('#tweet-limit')
    const getLink = $('#get-link')

    $('#generar-link').click(() => {
        let chromeValues = '';
        chrome.each((i, v) => {
            if ($(v).is(':checked')) chromeValues += $(v).val() + '-'
        })
        const link = `http://localhost/bear/WidgetsTres/Twitter/diseno/twitterTest.html?show-replies=${showReplies.is(":checked")}&theme=${theme.is(":checked")? 'dark' : 'light'}&chrome=${chromeValues.slice(0,-1)}&width=${width.val()}&height=${height.val()}&tweet-limit=${tweetLimit.val()}`
        getLink.val(link);
    })

});
/*
document.addEventListener('DOMContentLoaded', function() {
    M.AutoInit();
    const showReplies = document.getElementById('#show-replies')
    const theme = document.getElementById('#theme')
    const dnt = document.getElementById('#dnt')
    const chrome = document.getElementByClassName('.chrome')
    const width = document.getElementById('#width')
    const height = document.getElementById('#height')
    const tweetLimit = document.getElementById('#tweet-limit')
    const getLink = document.getElementById('#get-link')

    $('#generar-link').click(() => {
        let chromeValues = '';
        chrome.each((i, v) => {
            if ($(v).is(':checked')) chromeValues += $(v).val() + '-'
        })
        const link = `http://localhost/bear/WidgetsTres/Twitter/diseno/twitterTest.html?show-replies=${showReplies.is(":checked")}&theme=${theme.is(":checked")? 'dark' : 'light'}&chrome=${chromeValues.slice(0,-1)}&width=${width.val()}&height=${height.val()}&tweet-limit=${tweetLimit.val()}`
        getLink.val(link);
    })
});
 */

