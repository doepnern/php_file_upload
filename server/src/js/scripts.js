let _selectedFiles = [];

function updateFileDisplay() {
  const filePreviewContainer = document.getElementById(
    "file_preview_container"
  );
  while (filePreviewContainer.lastChild) {
    filePreviewContainer.removeChild(filePreviewContainer.lastChild);
  }
  const fileElemets = _selectedFiles.map((file) => {
    const fileElementContainer = document.createElement("div");
    fileElementContainer.classList.add("file_preview");

    const fileElementName = document.createElement("h5");
    fileElementName.innerText = file.name;

    const commentField = document.createElement("input");
    commentField.type = "text";
    commentField.placeholder = "Comment";
    commentField.name = "comment_" + file.id;
    commentField.id = "comment_" + file.id;

    fileElementContainer.append(fileElementName);
    fileElementContainer.append(commentField);

    return fileElementContainer;
  });
  filePreviewContainer.append(...fileElemets);
}

const replaceFiles = (files) => {
  _selectedFiles = files;
  updateFileDisplay();
};

document.addEventListener("DOMContentLoaded", function (event) {
  // ersetze alle files wenn neue ausgewählt werden
  const input = document.getElementById("userfile_input");
  input.addEventListener("change", function (e) {
    const newFiles = e.target.files;

    const newFilesArray = Array.from(newFiles);

    const files = newFilesArray.map((file) => ({
      fileSource: file,
      id: generateGuid(),
      status: "waiting",
      progress: 0,
      name: file.name,
    }));
    replaceFiles(files);
  });

  // wenn form submittet wird, schicke POST request an server
  const form = document.getElementById("multi_file_form");
  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData();
    _selectedFiles.forEach((file) => {
      // id als namen verwenden damit server weiß welcher comment zu welcher datei gehört
      formData.append("userfile[]", file.fileSource, file.id);

      // comment zu datei hinzufügen
      const comment = document.getElementById("comment_" + file.id).value;
      if (comment) {
        formData.append("comment_" + file.id, comment);
      }
    });
    const request = new Request("/handleUpload.php", {
      method: "POST",
      body: formData,
    });
    fetch(request)
      .then((response) => response.json())
      .then((jsonRes) => {
        const filePreviewContainer = document.getElementById(
          "file_preview_container"
        );
        filePreviewContainer.classList.add("success");
        console.log(jsonRes);
      })
      .catch((error) => {
        const filePreviewContainer = document.getElementById(
          "file_preview_container"
        );
        filePreviewContainer.classList.add("error");
        filePreviewContainer.appendChild(
          document.createTextNode("Error uploading files")
        );
        console.error(error);
      });
  });
});

// source : http://blog.shkedy.com/2007/01/createing-guids-with-client-side.html
function generateGuid() {
  var result, i, j;
  result = "";
  for (j = 0; j < 32; j++) {
    if (j == 8 || j == 12 || j == 16 || j == 20) result = result + "-";
    i = Math.floor(Math.random() * 16)
      .toString(16)
      .toUpperCase();
    result = result + i;
  }
  return result;
}
