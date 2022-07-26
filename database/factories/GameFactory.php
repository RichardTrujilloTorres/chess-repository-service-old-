<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'moves' => '
            [Event "Rated Blitz game"]
[Site "https://lichess.org/pKI1kjG9"]
[Date "2022.01.02"]
[White "Girome"]
[Black "rickynkarnax"]
[Result "0-1"]
[UTCDate "2022.01.02"]
[UTCTime "01:15:59"]
[WhiteElo "2431"]
[BlackElo "2264"]
[WhiteRatingDiff "-8"]
[BlackRatingDiff "+13"]
[WhiteTitle "NM"]
[Variant "Standard"]
[TimeControl "180+2"]
[ECO "B17"]
[Opening "Caro-Kann Defense: Karpov Variation"]
[Termination "Normal"]

1. e4 c6 2. d4 d5 3. Nc3 dxe4 4. Nxe4 Nd7 5. Nf3 Ngf6 6. Nxf6+ Nxf6 7. Be2 Bg4 8. O-O e6 9. c3 Be7 10. Bf4 O-O 11. Re1 Nd5 12. Bg3 a5 13. Ne5 Bxe2 14. Qxe2 a4 15. Rac1 a3 16. b3 Qa5 17. Nc4 Qa6 18. h4 Rfd8 19. h5 h6 20. Qf3 Nf6 21. Ne5 Qa5 22. Bh4 Qd5 23. Qe2 c5 24. dxc5 Qxc5 25. c4 Qd4 26. g3 Qd2 27. Rc2 Qxe2 28. Rexe2 Rd1+ 29. Kg2 Rad8 30. f3 Rb1 31. g4 Rdd1 32. Bf2 Bd6 33. Bg3 Bxe5 34. Bxe5 Nd7 35. Bc3 Nc5 36. Bb4 Nd3 37. Red2 Ne1+ 38. Kf2 Nxc2 39. Rxc2 Rb2 40. Re2 Rxe2+ 41. Kxe2 Ra1 0-1
            ',
            'user_id' => 1,
        ];
    }
}
