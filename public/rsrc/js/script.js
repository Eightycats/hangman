

$(document).ready(() => {

});

function toggleWhitelist(current_user_id, friend_id, whitelist) {
    request(
        "/toggle_whitelist/" + current_user_id + "/" + friend_id  + "/" + whitelist,
        {name: 'hello'},
        (result) => {
            if (result.responseJSON.success) {
                onWhitelisted(friend_id, whitelist);
            }
        }
    );
    return false;
}

function onWhitelisted(friend_id, whitelist) {
    let element = $('#whitelist_' + friend_id);
    if (whitelist == 1) {
        element.removeClass('toggleBoxOff');
        element.children().removeClass('textOff');
    } else {
        element.addClass('toggleBoxOff');
        element.children().addClass('textOff');
    }
}

/**
 * Sends an HTTP POST.
 *
 * @param {string} url
 * @param {Object} data the params to send.
 * @param {function} callback called with response on success.
 * @param {function} errorCallback called with response on failure.
 */
function post(url, data, callback, errorCallback) {
    request(url, data, callback, errorCallback, 'POST');
}

/**
 * Sends an HTTP GET request.
 *
 * @param {string} url
 * @param {Object} data the params to send.
 * @param {function} callback called with response on success.
 * @param {function} errorCallback called with reponse on failure.
 * @param {string} method HTTP GET vs. POST.
 */
function request(url, data, callback, errorCallback, method = 'GET') {
    $.ajax(url, {method: method, data: data, complete: (response, status) => {
            onResponse(response, status, callback, errorCallback);
        }});
}

/**
 * Generic portion of ajax response handling.
 *
 * @param {Object} response ajax response.
 * @param {string} status ajax status: 'success', 'unmodified', etc.
 * @param {function} callback
 * @param {function} errorCallback
 */
function onResponse(response, status, callback, errorCallback) {
    if (status === 'success' && response.status === 200) {
        callback(response);
    } else if (errorCallback) {
        errorCallback(response);
    }
}
