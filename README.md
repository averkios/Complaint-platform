# Complaint-platform

Το project αυτό δημιουργήθηκε στα πλαίσια του μαθήματος "Ειδικά θέματα κατανεμιμένων συστημάτων" στο ΤΕΙ Λαμίας στο οποίο και φοιτώ, και αφορά τη δημιουργία μιας πλατφόρμας παραπόνων. Για την ολοκλήρωση του χρειάστηκαν τέσσερις μήνες.

Ωστόσο θα μπορούσε να χρησιμοποιηθεί και για επαγγελματικό σκοπό.

Για τη δημιουργία του front-end χρησιμοποιήθηκε το Bootstrap (front-end framework), η δημιουργία του back-end είναι εξολοκλήρου από την αρχή, για τη παρουσίαση των στατιστικών χρησιμοποιήθηκε το morris.js plugin. Η βάση δεδομένων που χρησιμοποιεί είναι MySQL και διατίθεται πλήρης διαχείριση της από το back-end.
Το project είναι παραμετροποιημένο για όλες τις οθόνες (mobile-friendly).

<h3>Δυνατότητες:</h3>

Open for everyone:<br />
Όλοι μπορούν να δουν όλα τα παράπονα.

User register:<br />
Δυνατότητα εγγραφής.

Complaint insert:<br />
Δυνατότητα καταχώρησης παραπόνου από οποιονδήποτε.

User date:<br />
Διατηρούνται στοιχεία για κάθε χρήστη.

Form field persistence:<br />
Διατηρούνται τα στοιχεία των πεδίων της φόρμας σε περίπτωση λάθους.

Access control:<br />
Περιορισμός χρηστών από σελίδες που δεν έχουν δικαιώματα πρόσβασης, όπως οι σελίδες του διαχειριστή.

Cascade delete:<br />
Όταν διαγράφεται μια κατηγορία, διαγράφονται και όλες οι εγγραφές της. Το ίδιο ισχύει και για τους χρήστες.

Input validation:<br />
Έλεγχος εισαγωγής για επαλήθευση εγκυρότητας και αποφυγή "sql injection".

Alert boxes:<br />
Παράθυρα ενημέρωσης για σφάλματα ή ενημέρωση για την επιτυχή ολοκλήρωση μιας πράξης.

password encryption:<br />
Πάρα πολύ απλή κρυπτογράφηση κωδικών.

User aware:<br />
Το σύστημα γνωρίζει κάθε στιγμή ποιος το χρησιμοποιεί. (χρήστης, διαχειριστής, φιλοξενούμενος)

Category insert:<br />
Ο διαχειριστής μπορεί να εισάγει νέες κατηγορίες.

Duplicate aware:<br />
Το σύστημα γνωρίζει αν υπάρχει ήδη εγγεγραμμένος κάποιος χρήστης την στιγμή που γίνεται μια νέα εγγραφή ή αν υπάρχει ήδη μία κατηγορία όταν ο διαχειριστής εισάγει μια νέα.

Database managment:<br />
Ο διαχειριστής μπορεί να διαγράψει κατηγορίες, παράπονα, χρήστες, φιλοξενούμενους.

User capabilities:<br />
Κάθε χρήστης μπορεί να προβάλει και να διαγράφει τα παράπονα του.(διαγραφή αν το επιτρέπει ο διαχειριστής)

Database reset:<br />
Επαναφορά βάσης

Permission control:<br />
Ο διαχειριστής μπορεί να αλλάξει τα δικαιώματα των χρηστών όσων αφορά την ικανότητα τους να διαγράφουν τα παράπονα τους.

Sorting:<br />
Ταξινόμηση προβολής παραπόνων με βάση ημερομηνία ή κατηγορία.

Statistics:<br />
Το σύστημα εξάγει στατιστικά στοιχεία ζωγραφίζοντας τα σε παραστάσεις.

File export(xml, txt):<br />
Το σύστημα εξάγει στατιστικά στοιχεία σε αρχεία xml και txt, τα οποία είναι διαθέσιμα για προβολή στο φυλλομετρητή αλλά και για λήψη.

Guest upgrade:<br />
Το σύστημα αποθηκεύει τους χρήστες που κάνουν παράπονα ως φιλοξενούμενοι και αργότερα αν δημιουργήσουν λογαριασμό ανανεώνονται τα στοιχεία τους.

Dynamic:<br />
Όλα υπολογίζονται και αλλάζουν δυναμικά.

external frameworks,plugins:<br />
Bootstrap 3, morris.js.

<h3>Εξέλιξη</h3>

Τι πρέπει να βελτιωθεί:

- Η κρυπτογραφία των κωδικών των χρηστών

Τι πρέπει να προστεθεί:

- Script για τη δημιουργία της βάσης δεδομένων

<h3>License</h3>

Είστε ελεύθεροι να χρησιμοποιήσετε αυτό το project αρκεί να αναφέρερθεί η παρόυσα σελλίδα (https://github.com/averkios/Complaint-platform) που αφορά το project και από ποιόν αναπτύχθηκε (https://github.com/averkios).

<a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a><br />This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.
