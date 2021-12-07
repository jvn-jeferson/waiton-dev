<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
    <style>

    </style>
</head>
<body>

    <div class="top-bar">
        <button class="btn" id="prev-page">
            <i class="fas fa-arrow-circle-left"></i> Previous
        </button>
        <button class="btn" id="next-page">
            <i class="fas fa-arrow-circle-right"></i> Next
        </button>
        <span class="page-info">
            Page: <span id="page-num"></span> of <span id="page-count"></span>
        </span>
    </div>

    <canvas id="pdf-render"></canvas>
    

    
    <script type="text/javascript">
        const url = "{{asset('temp/sample.pdf')}}" //setURL function

        let pdfDoc = null,
            pageNum = 1,
            pageIsRendering = false,
            pageNumIsPending = null;

        const scale = 1.5,
            canvas = document.querySelector("#pdf-render"),
            ctx = canvas.getContext('2d');

        const renderPage = num => {
            pageIsRendering = true;

            pdfDoc.getPage(num).then(page => {
                const viewport = page.getViewport({ scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                
                const renderCtx = {
                    canvasContex:ctx, 
                    viewport
                }
                page.render(renderCtx).promise.then(() => {
                    pageIsRendering = false;

                    if(pageNumIsPending != null) {
                        renderPage(pageNumIsPending);
                        pageNumIsPending = null;
                    }
                });

                document.querySelector('#page-num').textContent = num;
            });
        };

        const queueRenderPage = num => {
            if(pageIsRendering) {
                pageNumIsPending = num;
            } else {
                renderPage(num);
            }
        }

        const showPrevPage = () => {
            if(pageNum <= 1) {
                return;
            }
            pageNum--;
            
            
            queueRenderPage(pageNum);
        }

        const showNextPage = () => {
            if(pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }

        

        pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
            pdfDoc = pdfDoc_;

            document.querySelector('#page-count').textContent = pdfDoc.numPages;

            renderPage(pageNum)
        });

        document.querySelector('#prev-page').addEventListener('click',showPrevPage);
        document.querySelector('#next-page').addEventListener('click', showNextPage);
    </script>
</body>
</html>