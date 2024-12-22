# Robot Karel 

Tato aplikace simuluje jednoduchého robota Karla, který se pohybuje po 2D herním poli a vykonává různé příkazy, jako je pohyb, otáčení a pokládání písmen a čísel. Aplikace je vytvořena pomocí HTML, CSS, PHP a využívá session pro uchování herního stavu.

## Funkce
- **Pohyb**: Karel se pohybuje po herním poli na základě zadaných příkazů (např. `KROK 3`).
- **Otáčení**: Karel se otočí doleva podle zadaného počtu (např. `VLEVOBOK 1`).
- **Pokládání písmen**: Karel může na své aktuální pozici umístit písmena i čísla (např. `POLOZ A`).
- **Resetování**: Hru lze resetovat příkazem `RESET`.

## Příkazy
- `KROK [n]`: Karel se pohne o [n] kroků ve směru, kterým je natočen. Pokud není zadáno číslo, Karel se pohne o 1 krok.
- `VLEVOBOK [n]`: Karel se otočí doleva o [n] 90 stupňů. Pokud není zadáno číslo, Karel se otočí jednou.
- `POLOZ [písmeno]`: Karel položí na svou aktuální pozici písmeno.
- `RESET`: Vyčistí herní pole a nastaví Karla zpět na výchozí pozici.

## Příklad použití
1. Zadejte příkaz: `KROK 3`
2. Karel se pohne o 3 kroky vpřed.
3. Zadejte příkaz: `VLEVOBOK 1`
4. Karel se otočí vlevo.
5. Zadejte příkaz: `POLOZ A`
6. Karel na své pozici položí písmeno "A".

## Spuštění
Pro spuštění jsem použil server přímo ve VSC v terminálu pomocí "php -S localhost:8000", tento command mi spustil server a následně jsem zkopíroval tento link "http://localhost:8000" a vložil do prohlížeče


## Technologie
- **PHP**: Pro serverovou logiku a zpracování herního stavu.
- **HTML/CSS**: Pro zobrazení herního pole a ovládání aplikace.

