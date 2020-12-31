function countDown () {

    var now         = new Date(),
        eventDate   = new Date(2019, 5 , 20),
        currentTime = now.getTime(), // number of millisecends 
        eventTime   = eventDate.getTime(), // number of millisecends 
        remTime     = eventTime - currentTime ,

        sec  = Math.floor( remTime / 1000 ),
        min  = Math.floor( sec / 60 ),
        hur  = Math.floor( min / 60 ),
        days = Math.floor( hur / 24 );


        sec %= 60;
        min %= 60;
        hur %= 24;

        document.getElementById('days').textContent    = days;
        document.getElementById('hours').textContent   = hur;
        document.getElementById('min').textContent     = min;
        document.getElementById('secends').textContent = sec;


        setTimeout( countDown , 1000);
};

countDown();