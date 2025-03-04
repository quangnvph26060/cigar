// ((e, t) => {
//     const a = {
//             shopInfo: {
//                 tsId: "XB329D0FECA1C20BC34639A428C44B4FC",
//                 name: "rauchr.de",
//                 url: "www.rauchr.de",
//                 language: "de",
//                 targetMarket: "DEU",
//                 ratingVariant: "WIDGET",
//                 eTrustedIds: {
//                     accountId: "acc-49cca1d5-3d1a-4ced-b3e4-c6373cec44e7",
//                     channelId: "chl-5e972434-5853-4bc0-8d96-668ee032629e",
//                 },
//                 buyerProtection: {
//                     certificateType: "CLASSIC",
//                     certificateState: "INTEGRATION",
//                     mainProtectionCurrency: "EUR",
//                     maxProtectionDuration: 30,
//                     plusProtectionAmount: 2e4,
//                     basicProtectionAmount: 100,
//                 },
//                 reviewSystem: {
//                     rating: {
//                         averageRating: 4.89,
//                         averageRatingCount: 9,
//                         overallRatingCount: 9,
//                     },
//                     reviews: [
//                         {
//                             average: 4,
//                             buyerStatement: null,
//                             changeDate: "9.2.2025",
//                         },
//                         {
//                             average: 5,
//                             buyerStatement:
//                                 "Eine exakte, sehr gute Prüfmethode, allerdings etwas belastend",
//                             changeDate: "13.1.2025",
//                         },
//                         {
//                             average: 5,
//                             buyerStatement: null,
//                             changeDate: "4.1.2025",
//                         },
//                     ],
//                 },
//                 features: [
//                     "MARS_REVIEWS",
//                     "MARS_EVENTS",
//                     "DISABLE_REVIEWREQUEST_SENDING",
//                     "MARS_QUESTIONNAIRE",
//                     "MARS_PUBLIC_QUESTIONNAIRE",
//                     "SHOP_CONSUMER_MEMBERSHIP",
//                     "GUARANTEE_RECOG_CLASSIC_INTEGRATION",
//                 ],
//                 consentManagementType: "OFF",
//                 urls: {
//                     profileUrl:
//                         "https://www.trustedshops.de/bewertung/info_XB329D0FECA1C20BC34639A428C44B4FC.html",
//                     profileUrlLegalSection:
//                         "https://www.trustedshops.de/bewertung/info_XB329D0FECA1C20BC34639A428C44B4FC.html#legal",
//                 },
//                 displayVariant: "reviews-only",
//                 variant: "reviews-only",
//                 twoLetterCountryCode: "DE",
//             },
//             "process.env": { STAGE: "prod" },
//             externalConfig: {
//                 trustbadgeScriptUrl:
//                     "https://widgets.trustedshops.com/assets/trustbadge.js",
//                 cdnDomain: "widgets.trustedshops.com",
//             },
//             elementIdSuffix: "-98e3dadd90eb493088abdc5597a70810",
//             buildTimestamp: "2025-02-10T05:21:38.887Z",
//             buildStage: "prod",
//         },
//         r = (a) => {
//             const { trustbadgeScriptUrl: r } = a.externalConfig;
//             let n = t.querySelector(`script[src="${r}"]`);
//             n && t.body.removeChild(n),
//                 (n = t.createElement("script")),
//                 (n.src = r),
//                 (n.charset = "utf-8"),
//                 n.setAttribute("data-type", "trustbadge-business-logic"),
//                 (n.onerror = () => {
//                     throw new Error(
//                         `The Trustbadge script could not be loaded from ${r}. Have you maybe selected an invalid TSID?`
//                     );
//                 }),
//                 (n.onload = () => {
//                     e.trustbadge?.load(a);
//                 }),
//                 t.body.appendChild(n);
//         };
//     "complete" === t.readyState
//         ? r(a)
//         : e.addEventListener("load", () => {
//               r(a);
//           });
// })(window, document);
