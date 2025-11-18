Etudiant: id, ETU, nom, prenom, dtn
Filiere: id, nom
Promotion: idProm, idFiliere
Inscription: id, DateInscription, idEtudiant, semestre, idPromo
Session: idSession, date
Avancement: idAvancement, idEtudiant, semestre, idSession
Rattrapage:id, idAvancement, idMatiere, noteRattrapage

Option: idOption,nom
Matiere: idMatiere,nom, UE
Credit: idCredit, idMatiere, idOption,semestre, credit,ensembleOptionnel(peutetre null ou int)
Note: idNote, idAvancement, note, idMatiere
