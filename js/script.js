
import translations from "./translations.js";

const languageSelector = document.querySelector("select");
languageSelector.addEventListener("change", (event) => {
  setLanguage(event.target.value);
  localStorage.setItem("lang", event.target.value);
});

document.addEventListener("DOMContentLoaded", () => {
 const language = localStorage.getItem("lang") || "en"; 
  setLanguage(language);
});

const setLanguage = (language) => {
  const elements = document.querySelectorAll("[data-lang]");
  elements.forEach((element) => {
    const translationKey = element.getAttribute("data-lang");
    element.textContent = translations[language][translationKey];
  });
  if (language==="ar")
  document.dir="rtl" ;
else {
  document.dir="ltr" ;
}
};
