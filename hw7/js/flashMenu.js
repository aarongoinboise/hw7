$(document).ready(() => {
    const lheight = $('.element').height();
    setInterval(() => {
        // $('#menuBarItemSelected').css('background-color', '#dffcff');
        // $('#menuBarItemSelected').css('background-color', 'yellow');
        var body = $('#menuBarItemSelected');
        var colors = ['lightgreen', 'lightpink', '#dffcff'];
        var currentIndex = 0;
        setInterval(function () {
            body.css({
                backgroundColor: colors[currentIndex]
            });
            if (!colors[currentIndex]) {
                currentIndex = 0;
            } else {
                currentIndex++;
            }
        }, 100);

        // The following code keeps the 
        // height of the div intact
        if ($('.element').height() !== 0) {
            $('.element').css('height', `${lheight}px`);
        }
    }, 100);
});