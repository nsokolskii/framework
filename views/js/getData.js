async function getData(url = '', query = '') {
    const response = await fetch(url + "?" + new URLSearchParams({
        "fetch": 'value',
    }), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    return await response.json();
}