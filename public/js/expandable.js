// sourced from https://codepen.io/chriscoyier/pen/WpaWBv

'use strict';

class Expandable {
    constructor() {
        this._expandable = document.querySelector('.phase-wrapper');
        this._expandableContents = this._expandable.querySelector('.courses');
        this._expandableToggle = this._expandable.querySelector('.phase-toggle');
        this._expandableTitle = this._expandable.querySelector('.phase-header');

        this._expanded = true;
        this._animate = false;
        this._collapsed;

        this.expand = this.expand.bind(this);
        this.collapse = this.collapse.bind(this);
        this.toggle = this.toggle.bind(this);

        this._calculateScales();
        this._createEaseAnimations();
        this._addEventListeners();

        this.collapse();
        this.activate();
    }

    activate() {
        this._expandable.classList.add('expand-activate');
        this._animate = true;
    }

    collapse() {
        if (!this._expanded) {
            return;
        }
        this._expanded = false;

        const {x, y} = this._collapsed;
        const invX = 1 / x;
        const invY = 1 / y;

        this._expandable.style.transform = `scale(${x}, ${y})`;
        this._expandableContents.style.transform = `scale(${invX}, ${invY})`;

        if (!this._animate) {
            return;
        }

        this._applyAnimation({expand: false});
    }

    expand() {
        if (this._expanded) {
            return;
        }
        this._expanded = true;

        this._expandable.style.transform = `scale(1,1)`;
        this._expandableContents.style.transform = `scale(1, 1)`;

        if (!this._animate) {
            return;
        }

        this._applyAnimation({expand: true});
    }

    toggle() {
        if (this._expanded) {
            this.collapse();
            return;
        }

        this.expand();
    }

    _addEventListeners() {
        this._expandableToggle.addEventListener('click', this.toggle);
    }

    _applyAnimation({expand} = opts) {
        this._expandable.classList.remove('expandable--expanded');
        this._expandable.classList.remove('expandable--collapsed');
        this._expandableContents.remove('expandableContents--expanded');
        this._expandableContents.rem('expandableContents--collapsed');

        window.getComputedStyle(this._expandable).transform;

        if (expand) {
            this._expandable.classList.add('expandable--expanded');
            this._expandableContents.classList.add('expandableContents--collapsed');
            return;
        }
    }

    _calculateScales() {
        const collapsed = this._expandableTitle.getBoundingClientRect();
        const expanded = this._expandable.getBoundingClientRect();

        this._collapsed = {
            x: collapsed.width / expanded.width,
            y: collapsed.height / expanded.height
        }
    }

    _createEaseAnimations () {
        let expandEase = document.querySelector('.expand-ease');
        if (expandEase) {
            return expandEase;
        }

        expandEase = document.createElement('style');
        expandEase.classList.add('expand-ease');

        const ExpandAnimation = [];
        const ExpandContentsAnimation = [];
        const CollapseAnimation = [];
        const CollapseContentsAnimation = [];
        for (let i = 0; i <= 100; i++) {
            const step = this._ease(i/100);
            const startX = this._collapsed.x;
            const startY = this._collapsed.y;
            const endX = 1;
            const endY = 1;

            // Expand animation.
            this._append({
                i,
                step,
                startX: this._collapsed.x,
                startY: this._collapsed.y,
                endX: 1,
                endY: 1,
                outerAnimation: ExpandAnimation,
                innerAnimation: ExpandContentsAnimation
            });

            // Collapse animation.
            this._append({
                i,
                step,
                startX: 1,
                startY: 1,
                endX: this._collapsed.x,
                endY: this._collapsed.y,
                outerAnimation: CollapseAnimation,
                innerAnimation: CollapseContentsAnimation
            });
        }

        expandEase.textContent = `
      @keyframes menuExpandAnimation {
        ${ExpandAnimation.join('')}
      }

      @keyframes menuExpandContentsAnimation {
        ${ExpandContentsAnimation.join('')}
      }
      
      @keyframes menuCollapseAnimation {
        ${CollapseAnimation.join('')}
      }

      @keyframes menuCollapseContentsAnimation {
        ${CollapseContentsAnimation.join('')}
      }`;

        document.head.appendChild(expandEase);
        return expandEase;
    }

    _append ({
                 i,
                 step,
                 startX,
                 startY,
                 endX,
                 endY,
                 outerAnimation,
                 innerAnimation}=opts) {

        const xScale = startX + (endX - startX) * step;
        const yScale = startY + (endY - startY) * step;

        const invScaleX = 1 / xScale;
        const invScaleY = 1 / yScale;

        outerAnimation.push(`
      ${i}% {
        transform: scale(${xScale}, ${yScale});
      }`);

        innerAnimation.push(`
      ${i}% {
        transform: scale(${invScaleX}, ${invScaleY});
      }`);
    }

    _clamp (value, min, max) {
        return Math.max(min, Math.min(max, value));
    }

    _ease (v, pow=4) {
        v = this._clamp(v, 0, 1);

        return 1 - Math.pow(1 - v, pow);
    }
}

new Expandable();