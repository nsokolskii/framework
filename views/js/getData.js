async function getData(url = '') {
    const response = await fetch(url + "?" + new URLSearchParams({
        "fetch": 'value'
    }), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    return await response.json();
}