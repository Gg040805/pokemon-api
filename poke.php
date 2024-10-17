<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Api Pokemon</title>
</head>
<body>
    
</body>
</html><style>
    #poken {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        grid-column-gap: 15px;
        grid-row-gap: 25px;
        padding: 20px;
    }

    #poken div {
        border: 2px solid #333;
        padding: 10px;
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    #poken div:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    img {
        border: 1px solid #ddd;
        border-radius: 50%;
        transition: transform 0.3s;
    }

    img:hover {
        transform: rotate(360deg);
    }

    p {
        margin-top: 10px;
        font-size: 18px;
        font-weight: bold;
        color: #444;
    }
</style>

<div id="poken"></div>

<script>
    fetch('https://pokeapi.co/api/v2/pokemon?limit=100&offset=0')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        let pokemons = data.results;
        let maindiv = document.getElementById("poken");
        pokemons.forEach(pokemon => {
            fetch(pokemon.url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(characteristics => {
                const para = document.createElement("div");
                fetch(characteristics.species.url)
                
                .then(response => {
                    return response.json();
                })
                .then(color => {
                    para.style.background = color.color.name;
                });
                console.log(characteristics)

                const p = document.createElement("p");
                p.innerHTML = pokemon.name.charAt(0).toUpperCase() + pokemon.name.slice(1);

                const type = document.createElement("p");
                for (let index = 0; index < characteristics.types.length; index++) {
                    type.innerHTML += characteristics.types[index].type.name+"<br>";
                }

                const img = document.createElement("img");
                img.setAttribute("src", characteristics.sprites.front_default);
                img.width = 150;
                img.height = 150;

                para.appendChild(img);
                para.appendChild(p);
                para.appendChild(type)
                maindiv.appendChild(para);
            });
        });
    })
    .catch(error => console.error('Error:', error));
</script>
