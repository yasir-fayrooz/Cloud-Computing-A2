'use strict';
const cheerio = require('cheerio');
const express = require('express');
const app = express();
var request = require("request");
var fs = require("fs");

var options = { method: 'GET',
    url: 'https://api.twitch.tv/kraken/games/top',
    qs: { limit: 25 },
    headers:
        {   'Accept': 'application/vnd.twitchtv.v5+json',
            'Client-ID': 'lyf5sgkhrab60gjy3hjzo3dmogrhnl' } };

request(options, function (error, response, body) {
    if (error) throw new Error(error);
    fs.writeFile('./public/tw.json', body, function(err) {
        if (err)
            return console.error(err);
    });
});

request('https://steamcharts.com/top', function(err, response, html) {
  if (!err && response.statusCode == 200) {
    let $ = cheerio.load(html)

    const siteBody = $('body')

    const table = siteBody.find('tbody')

    const data = []
    const onlData = []
    $('tbody').find('a').each(function(i, el) {
      data[i] = $(this).text().replace(/\s+/g, '')
    })
    data.join(',')
    //console.log(data);

    $('tbody').find('td.num').filter(function (i, el) {
      return $(this).attr('class') === 'num'
    }).each(function(i, el) {
      onlData[i] = $(this).text()
    })
    onlData.join(',')
    //console.log(onlData);

    var scrapped = {
      game: data,
      online: onlData
    }
    fs.writeFile('./public/st.json', JSON.stringify(scrapped), function(err) {
        if (err)
            return console.error(err);
    });
    //writetoJSON.write(JSON.stringify(scrapped))
  }
})

// Imports the Google Cloud client library
const {Storage} = require('@google-cloud/storage');

// Creates a client
const storage = new Storage();

const bucketName = 'cc-assinment2.appspot.com';
const filename = './public/tw.json';
const filename2 = './public/st.json';

// Uploads a local file to the bucket
storage.bucket(bucketName).upload(filename, {
  // Support for HTTP requests made with `Accept-Encoding: gzip`
  gzip: true,
  metadata: {
    cacheControl: 'no-cache',
  },
});
storage.bucket(bucketName).upload(filename2, {
  // Support for HTTP requests made with `Accept-Encoding: gzip`
  gzip: true,
  metadata: {
    cacheControl: 'no-cache',
  },
});

//console.log(`${filename2} uploaded to ${bucketName}.`);

var contents = fs.readFileSync(filename);
var contents2 = fs.readFileSync(filename2);
var cont = [
  contents,
  contents2
]
// Define to JSON type
var jsonContent = JSON.parse(contents);
var jsonContent2 = JSON.parse(contents2);

//console.log(jsonContent2);

// Use the built-in express middleware for serving static files from './public'
app.use('/static', express.static('public'));
app.set('view engine', 'pug');


app.get('/', (req, res) => {
  //res.sendFile(__dirname + '/index.html', {jsonContent: 'content'});
  res.render('index', {data: cont})
});

// Start the server
const PORT = process.env.PORT || 8080;
app.listen(PORT, () => {
  console.log(`App listening on port ${PORT}`);
  console.log('Press Ctrl+C to quit.');
});
