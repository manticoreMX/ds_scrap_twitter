<div id="container"></div>
<script src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
<script>
    twttr.widgets.createTimeline({
            sourceType: "profile",
            screenName: "cbre"
        },
        document.getElementById("container"), 
        {
            theme: 'dark',
            height: 200,
            chrome: 'nofooter noheader'
        }
    );
</script>