	fetch('http://docketu.iutnc.univ-lorraine.fr:44010/spectacles').
		then((resp) => resp.json()).then((data) => {
			console.log(data);
		});

