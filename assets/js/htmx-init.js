import 'htmx.org';

window.htmx = require('htmx.org');

// don't handle 422 http response (form validation error) as an error.
document.body.addEventListener('htmx:beforeOnLoad', function (evt) {
    if (evt.detail.xhr.status === 422) {
        evt.detail.shouldSwap = true;
        evt.detail.isError = false;
    }
});

