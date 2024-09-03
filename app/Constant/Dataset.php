<?php

namespace App\Constant;

class Dataset
{

    public const MEDICINES = [
        ["name" => "Aspirin", "category" => "Tablet", "description" => "An analgesic and anti-inflammatory medication used to relieve pain, reduce fever, and prevent blood clots."],
        ["name" => "Ibuprofen", "category" => "Tablet", "description" => "A nonsteroidal anti-inflammatory drug (NSAID) used to treat pain, fever, and inflammation."],
        ["name" => "Acetaminophen", "category" => "Tablet", "description" => "A common pain reliever and fever reducer that is not an NSAID. It works by elevating the body's pain threshold."],
        ["name" => "Lisinopril", "category" => "Tablet", "description" => "An angiotensin-converting enzyme (ACE) inhibitor used to treat high blood pressure, heart failure, and to improve survival after a heart attack."],
        ["name" => "Simvastatin", "category" => "Tablet", "description" => "A statin medication used to lower cholesterol and reduce the risk of cardiovascular diseases."],
        ["name" => "Metformin", "category" => "Tablet", "description" => "An oral antidiabetic medication used to treat type 2 diabetes by improving insulin sensitivity and reducing glucose production in the liver."],
        ["name" => "Amlodipine", "category" => "Tablet", "description" => "A calcium channel blocker used to treat high blood pressure and coronary artery disease."],
        ["name" => "Levothyroxine", "category" => "Tablet", "description" => "A thyroid hormone replacement used to treat hypothyroidism."],
        ["name" => "Omeprazole", "category" => "Capsule", "description" => "A proton pump inhibitor used to reduce stomach acid production and treat conditions like gastroesophageal reflux disease (GERD)."],
        ["name" => "Metoprolol", "category" => "Tablet", "description" => "A beta-blocker used to treat high blood pressure, chest pain (angina), and heart failure."],
        ["name" => "Atorvastatin", "category" => "Tablet", "description" => "A statin medication used to lower cholesterol levels and reduce the risk of cardiovascular diseases."],
        ["name" => "Losartan", "category" => "Tablet", "description" => "An angiotensin II receptor blocker (ARB) used to treat high blood pressure and diabetic nephropathy."],
        ["name" => "Gabapentin", "category" => "Capsule", "description" => "An anticonvulsant medication used to treat seizures and nerve pain caused by shingles."],
        ["name" => "Amoxicillin", "category" => "Capsule", "description" => "An antibiotic used to treat bacterial infections."],
        ["name" => "Azithromycin", "category" => "Tablet", "description" => "An antibiotic used to treat a variety of bacterial infections."],
        ["name" => "Ciprofloxacin", "category" => "Tablet", "description" => "A fluoroquinolone antibiotic used to treat various bacterial infections."],
        ["name" => "Doxycycline", "category" => "Capsule", "description" => "A tetracycline antibiotic used to treat a variety of bacterial infections."],
        ["name" => "Albuterol", "category" => "Inhaler", "description" => "A bronchodilator used to treat asthma and chronic obstructive pulmonary disease (COPD)."],
        ["name" => "Fluticasone", "category" => "Nasal Spray", "description" => "A corticosteroid used to treat nasal symptoms such as congestion, sneezing, and runny nose caused by seasonal or year-round allergies."],
        ["name" => "Montelukast", "category" => "Tablet", "description" => "A leukotriene receptor antagonist used to treat allergies and prevent asthma attacks."],
        ["name" => "Loratadine", "category" => "Tablet", "description" => "An antihistamine used to relieve allergy symptoms such as sneezing, runny nose, and itchy eyes."],
        ["name" => "Cetirizine", "category" => "Tablet", "description" => "An antihistamine used to treat allergy symptoms like itching, runny nose, and sneezing."],
        ["name" => "Diphenhydramine", "category" => "Tablet", "description" => "An antihistamine used to relieve symptoms of allergy, hay fever, and the common cold."],
        ["name" => "Sertraline", "category" => "Tablet", "description" => "A selective serotonin reuptake inhibitor (SSRI) used to treat depression, obsessive-compulsive disorder (OCD), panic disorder, and social anxiety disorder."],
        ["name" => "Escitalopram", "category" => "Tablet", "description" => "A selective serotonin reuptake inhibitor (SSRI) used to treat depression and generalized anxiety disorder."],
        ["name" => "Fluoxetine", "category" => "Capsule", "description" => "A selective serotonin reuptake inhibitor (SSRI) used to treat depression, obsessive-compulsive disorder (OCD), and panic disorder."],
        ["name" => "Paroxetine", "category" => "Tablet", "description" => "A selective serotonin reuptake inhibitor (SSRI) used to treat depression, panic disorder, social anxiety disorder, and premenstrual dysphoric disorder."],
        ["name" => "Venlafaxine", "category" => "Capsule", "description" => "A serotonin-norepinephrine reuptake inhibitor (SNRI) used to treat depression and anxiety disorders."],
        ["name" => "Olanzapine", "category" => "Tablet", "description" => "An atypical antipsychotic used to treat schizophrenia and bipolar disorder."],
        ["name" => "Risperidone", "category" => "Tablet", "description" => "An atypical antipsychotic used to treat schizophrenia and bipolar disorder."],
        ["name" => "Quetiapine", "category" => "Tablet", "description" => "An atypical antipsychotic used to treat schizophrenia and bipolar disorder."],
        ["name" => "Haloperidol", "category" => "Tablet", "description" => "A typical antipsychotic used to treat schizophrenia and acute psychotic states."],
        ["name" => "Aripiprazole", "category" => "Tablet", "description" => "An atypical antipsychotic used to treat schizophrenia, bipolar disorder, and major depressive disorder."],
        ["name" => "Diazepam", "category" => "Tablet", "description" => "A benzodiazepine used to treat anxiety, seizures, and muscle spasms."],
        ["name" => "Lorazepam", "category" => "Tablet", "description" => "A benzodiazepine used to treat anxiety disorders and agitation."],
        ["name" => "Clonazepam", "category" => "Tablet", "description" => "A benzodiazepine used to treat seizures and panic disorder."],
        ["name" => "Alprazolam", "category" => "Tablet", "description" => "A benzodiazepine used to treat anxiety and panic disorders."],
        ["name" => "Warfarin", "category" => "Tablet", "description" => "An anticoagulant used to prevent blood clots and reduce the risk of stroke, heart attack, and other clot-related conditions."],
        ["name" => "Clopidogrel", "category" => "Tablet", "description" => "An antiplatelet medication used to reduce the risk of heart attack and stroke in patients with atherosclerosis or recent heart attack."],
        ["name" => "Rivaroxaban", "category" => "Tablet", "description" => "An anticoagulant used to reduce the risk of stroke and blood clots in people with atrial fibrillation and to treat or prevent deep vein thrombosis (DVT) and pulmonary embolism (PE)."],
        ["name" => "Apixaban", "category" => "Tablet", "description" => "An anticoagulant used to reduce the risk of stroke and blood clots in people with atrial fibrillation, and to treat or prevent deep vein thrombosis (DVT) and pulmonary embolism (PE)."],
        ["name" => "Enoxaparin", "category" => "Injection", "description" => "A low molecular weight heparin used to prevent and treat deep vein thrombosis (DVT) and pulmonary embolism (PE)."],
        ["name" => "Esomeprazole", "category" => "Capsule", "description" => "A proton pump inhibitor used to reduce stomach acid production and treat conditions like gastroesophageal reflux disease (GERD)."],
        ["name" => "Pantoprazole", "category" => "Tablet", "description" => "A proton pump inhibitor used to reduce stomach acid production and treat conditions like gastroesophageal reflux disease (GERD)."],
        ["name" => "Ranitidine", "category" => "Tablet", "description" => "An H2 blocker used to reduce stomach acid production and treat conditions like gastroesophageal reflux disease (GERD)."],
        ["name" => "Furosemide", "category" => "Tablet", "description" => "A loop diuretic used to treat edema (fluid retention) and hypertension (high blood pressure)."],
        ["name" => "Hydrochlorothiazide", "category" => "Tablet", "description" => "A thiazide diuretic used to treat edema (fluid retention) and hypertension (high blood pressure)."],
        ["name" => "Spironolactone", "category" => "Tablet", "description" => "A potassium-sparing diuretic used to treat edema (fluid retention) and hypertension (high blood pressure)."],
        ["name" => "Digoxin", "category" => "Tablet", "description" => "A medication used to treat heart failure and certain types of irregular heartbeats (arrhythmias)."],
        ["name" => "Carvedilol", "category" => "Tablet", "description" => "A beta-blocker used to treat heart failure and hypertension (high blood pressure)."],
        ["name" => "Diltiazem", "category" => "Tablet", "description" => "A calcium channel blocker used to treat hypertension (high blood pressure) and angina (chest pain)."],
        ["name" => "Verapamil", "category" => "Tablet", "description" => "A calcium channel blocker used to treat hypertension (high blood pressure) and angina (chest pain)."],
        ["name" => "Atenolol", "category" => "Tablet", "description" => "A beta-blocker used to treat hypertension (high blood pressure) and angina (chest pain)."],
        ["name" => "Propranolol", "category" => "Tablet", "description" => "A nonselective beta-blocker used to treat hypertension (high blood pressure), angina (chest pain), and tremors."],
        ["name" => "Hydralazine", "category" => "Tablet", "description" => "A vasodilator used to treat hypertension (high blood pressure)."],
        ["name" => "Nitroglycerin", "category" => "Tablet", "description" => "A vasodilator used to treat angina (chest pain) and heart failure."],
        ["name" => "Isosorbide", "category" => "Tablet", "description" => "A vasodilator used to prevent angina (chest pain) and manage congestive heart failure."],
        ["name" => "Insulin", "category" => "Injection", "description" => "A hormone used to treat diabetes by regulating blood sugar levels."],
        ["name" => "Metoprolol", "category" => "Tablet", "description" => "A beta-blocker used to treat hypertension (high blood pressure), angina (chest pain), and heart failure."],
        ["name" => "Levofloxacin", "category" => "Tablet", "description" => "A fluoroquinolone antibiotic used to treat bacterial infections."],
        ["name" => "Clarithromycin", "category" => "Tablet", "description" => "A macrolide antibiotic used to treat bacterial infections."],
        ["name" => "Morphine", "category" => "Tablet", "description" => "An opioid analgesic used to treat moderate to severe pain."],
        ["name" => "Oxycodone", "category" => "Tablet", "description" => "An opioid analgesic used to treat moderate to severe pain."],
        ["name" => "Tramadol", "category" => "Tablet", "description" => "A centrally acting analgesic used to treat moderate to moderately severe pain."],
        ["name" => "Hydrocodone", "category" => "Tablet", "description" => "An opioid analgesic used to treat moderate to severe pain."],
        ["name" => "Methotrexate", "category" => "Tablet", "description" => "An antimetabolite used to treat cancer, rheumatoid arthritis, and psoriasis."],
        ["name" => "Prednisone", "category" => "Tablet", "description" => "A corticosteroid used to treat inflammatory conditions, autoimmune disorders, and certain types of"]
    ];

    public const CATEGORIES = [
        'Tablet',
        'Capsule',
        'Nasal Spray',
        'Injection',
        'Inhaler'
    ];

    public const SUPPLIER = [
        'Beximco',
        'Squre',
        'Opsonine',
        'Reneta',
        'Acme',
    ];

    public const UNIT = array(
        "5 : 5" => 25,
        "1 : 5" => 5,
        "1 : 1" => 1,
        "10 : 5" => 50,
        "6 : 6" => 36,
        "4 : 5" => 20,
        "4 : 1" => 4,
    );

    public const GENERIC = array(
        "Acetaminophen",
        "Ibuprofen",
        "Aspirin",
        "Lisinopril",
        "Simvastatin",
        "Metformin",
        "Loratadine",
        "Cetirizine",
        "Omeprazole",
        "Pantoprazole",
        "Amoxicillin",
        "Cephalexin",
        "Ciprofloxacin",
        "Doxycycline",
        "Gabapentin",
        "Oxycodone",
        "Hydrocodone",
        "Tramadol",
        "Warfarin",
        "Clopidogrel",
        "Fluoxetine",
        "Sertraline",
        "Escitalopram",
        "Paroxetine",
        "Amlodipine",
        "Losartan",
        "Levothyroxine",
        "Atorvastatin",
        "Rosuvastatin"
    );

    public const CURRENCY = ['BDT'=>'BDT','USD'=>'USD',"Euro"=>"Euro"];
}
