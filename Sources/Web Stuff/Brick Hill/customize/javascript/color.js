var ceSpan = document.getElementById('ce');
var colorForm = document.getElementById('colors');
var action = "?regen&part=";

function headColor() {
	var target = "head";
	ceSpan.innerHTML = "Head";
	colorForm.setAttribute("action", action + target);
}

function torsoColor() {
	var target = "torso";
	ceSpan.innerHTML = "Torso";
	colorForm.setAttribute("action", action + target);
}

function rArmColor() {
	var target = "rightArm";
	ceSpan.innerHTML = "Right Arm";
	colorForm.setAttribute("action", action + target);
}

function lArmColor() {
	var target = "leftArm";
	ceSpan.innerHTML = "Left Arm";
	colorForm.setAttribute("action", action + target);
}

function rLegColor() {
	var target = "rightLeg";
	ceSpan.innerHTML = "Right Leg";
	colorForm.setAttribute("action", action + target);
}
 
function lLegColor() {
	var target = "leftLeg";
	ceSpan.innerHTML = "Left Leg";
	colorForm.setAttribute("action", action + target);
}