function asyncRequest(path, value, page, whereToLoad){
    const request = new XMLHttpRequest();

    const url = path;
    let pageId = window.location.href.split('/');
    pageId = pageId[pageId.indexOf(page) + 1]
    const params = "value=" + value + "&page=" + pageId;

    request.open('POST', url, true);

    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    request.addEventListener("readystatechange", () => {

        if (request.readyState === 4 && request.status === 200) {
            ReactDOM.render(<div dangerouslySetInnerHTML={{__html: request.responseText}} />, document.getElementById(whereToLoad));
        }
    });

    request.send(params);
}