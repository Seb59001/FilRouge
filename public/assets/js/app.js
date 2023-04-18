(function($){

    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');
        // $a.text('Chargement');
        $.ajax(url, {
            success: function() {
                var res = confirm("Êtes-vous sûr de vouloir supprimer?");
                if(res){
                    $a.parents('tr').fadeOut();
                }
            },
            error: function(jqxhr){
                $a.text('supprimer')
                alert(jqxhr.responseText);
            }
        });
    });

})(jQuery);



// document.addEventListener('DOMContentLoaded', function() {
//     var initialLocaleCode = 'fr';
//     var localeSelectorEl = document.getElementById('locale-selector');
//     var calendarEl = document.getElementById('calendar');

//     var calendar = new FullCalendar.Calendar(calendarEl, {
//         buttonText: {
//             prev: 'Précédent',
//             next: 'Suivant',
//             today: 'Aujourd\'hui',
//             year: 'Année',
//             month: 'Mois',
//             week: 'Semaine',
//             day: 'Jour',
//             list: 'Planning',
//         },
//         headerToolbar: {
//             left: 'prev,next today',
//             center: 'title,addEventButton',
//             right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
//         },

//         weekText: 'Sem.',
//         weekTextLong: 'Semaine',
//         allDayText: 'Toute la journée',
//         moreLinkText: 'en plus',
//         noEventsText: 'Aucun évènement à afficher',
//         locale: 'fr',
//         local: 'fr',
//         buttonIcons: false, // show the prev/next text
//         weekNumbers: true,
//         navLinks: true, // can click day/week names to navigate views
//         editable: true,
//         dayMaxEvents: true, // allow "more" link when too many events
//         events: 'https://fullcalendar.io/api/demo-feeds/events.json?overload-day'
//     });

//     calendar.render();

//     // build the locale selector's options
//     calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
//         var optionEl = document.createElement('option');
//         optionEl.value = localeCode;
//         optionEl.selected = localeCode === initialLocaleCode;
//         optionEl.innerText = localeCode;
//         localeSelectorEl.appendChild(optionEl);
//     });

//     // when the selected option changes, dynamically change the calendar option
//     localeSelectorEl.addEventListener('change', function() {
//         if (this.value) {
//             calendar.setOption('local', 'fr');
//         }
//     });

// });

function strToDom(str) {
    //me firtChild permettra de mettre les valeurs avec des balises SVG
    return document.createRange().createContextualFragment(str).firstChild;
}

function easeOutExpo(x) {
    return x === 1 ? 1 : 1 - Math.pow(2, -10 * x)
}

class Point {
    constructor(x, y) {
        this.x = x
        this.y = y
    }
    toSvgPath() {
        return `${this.x} ${this.y}`
    }

    static fromAngle(angle) {
        return new Point(Math.cos(angle), Math.sin(angle))
    }
}

// @property {number[]} data
// @property {SVGPathElement[]} paths

class PieChart extends HTMLElement {
    constructor() {
        super()

        // Pas d'utilisation de l'exterieur mais il faut en mettre un 
        const shadow = this.attachShadow({ mode: 'open' })

        const labels = this.getAttribute('labels')?.split(';') ?? []
        // COULEUR : variable qui détermine les différentes couleurs, des différents chemins
        const colors = this.getAttribute('colors')?.split(';') ?? ['#DEBFD2', '#A9BEC7', '#A9BEC7', '#519D7A', '#939694', '#217D64', '#5D605D', '#4F8C8A', '#266F56', '#154F3B'];
        //extirper les données et on spit les différentes valeurs par rapport au ";" et mapper les difféntes valeurs 
        this.data = this.getAttribute('data').split(';').map(v => parseFloat(v))

        const svg = strToDom(`<svg viewBox="-1 -1 2 2">
        <g mask="url(#graphMask)">

        </g>
        <mask id="graphMask">
       <rect fill="white" x="-1" y="-1" width="2" height="2"/>
        <circle r="0.2" fill="black"/>

        </mask>
        </svg>`)
        const pathGroup = svg.querySelector('g')
        const maskGroup = svg.querySelector('mask')
        const gap = this.getAttribute('gap') ?? '0.01'

        //ON CREE LES CHEMINS 
        this.paths = this.data.map((_, k) => {
            const color = colors[k % (colors.length - 1)]
            const path = document.createElementNS('http://www.w3.org/2000/svg', 'path')
            path.setAttribute('fill', color)
            pathGroup.appendChild(path)
            return path

        })

        this.lines = this.data.map((_) => {
            const line = document.createElementNS('http://www.w3.org/2000/svg', 'line')
            line.setAttribute('stroke', '#000')
            line.setAttribute('stroke-width', gap)
            line.setAttribute('x1', '0')
            line.setAttribute('y1', '0')
            maskGroup.appendChild(line)
            return line

        })

        this.labels = labels.map((label) => {
            const div = document.createElement('div')
            div.innerText = label
            shadow.appendChild(div)
            return div
        })

        const style = document.createElement('style');
        style.innerHTML = `
            :host {
                display: block;
                position: relative;
            }
            svg {
                width: 100%;
                height: 100%;
            }
            path {
                cursor: pointer;
                transition: opacity .3s;
            }
            path:hover {
                opacity: 0.5;
            }
            div {
                position: absolute;
                top: 0;
                left: 0;
                font-size: 0.7rem;
                paddind: .1em .2em;
                transform: translate(-50%, -50%);
                
                text-shadow: #FFFFF 1px 1px 1px;
                font-family: 'Playfair Display', serif;
                color: rgb(10, 33, 52);
                font-size: x-large;
            }
        `
        shadow.appendChild(style)
        shadow.appendChild(svg)
        shadow.appendChild(svg)
    }

    connectedCallback() {
        const now = Date.now()
        const duration = 1000
        const draw = () => {
            const t = (Date.now() - now) / duration
            if (t < 1) {
                this.draw(easeOutExpo(t))
                window.requestAnimationFrame(draw)
            } else {
                this.draw(1)
            }
        }
        window.requestAnimationFrame(draw)
    }

    draw(progress = 1) {
        // ATTENTION ATTENTION CALCUL DE LA SOMME QUI COMMENCE A ZERO 
        const total = this.data.reduce((acc, v) => acc + v, 0)
        let angle = Math.PI / -2

        let start = new Point(0, -1)
        for (let k = 0; k < this.data.length; k++) {
            this.lines[k].setAttribute('x2', start.x)
            this.lines[k].setAttribute('y2', start.y)
            const ratio = (this.data[k] / total) * progress
            this.positionLabel(this.labels[k], angle + ratio * Math.PI)


            angle += ratio * 2 * Math.PI
            const end = Point.fromAngle(angle)
            const largeFlag = ratio > .5 ? '1' : '0'
            this.paths[k].setAttribute('d', `M 0 0 L ${start.toSvgPath()} A 1 1 0 ${largeFlag} 1 ${end.toSvgPath()} L 0 0 `)

            start = end
        }
    }
    /**
     * Positionne le label en fonction de l'angle
     * @param {HTMLDivElement|undefined} label 
     * @param {number} angle 
     */
    positionLabel(label, angle) {
        if (!label || !angle) {
            return;
        }
        const point = Point.fromAngle(angle)
        label.style.setProperty('top', `${(point.y * 0.60 * 0.50 + 0.50) * 100}%`)
        label.style.setProperty('left', `${(point.x * 0.60 * 0.50 + 0.50) * 100}%`)
    }
}


customElements.define('pie-chart', PieChart)